<?php

namespace Sikessem\Capsule;

use Closure;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionType;
use ReflectionUnionType;
use Sikessem\Capsule\Exceptions\ReflectorException;

final class Reflector
{
    /**
     * @param array<object|string>|string|callable(mixed ...$args): mixed $callback
     */
    public static function invoke(array|string|callable $callback, mixed ...$arguments): mixed
    {
        return self::invokeArgs($callback, $arguments);
    }

    /**
     * @param  array<object|string>|string|callable(mixed ...$args): mixed  $callback
     * @param  array<mixed>  $arguments
     */
    public static function invokeArgs(array|string|callable $callback, array $arguments = []): mixed
    {
        if (self::isMethod($callback)) {
            if (is_array($callback)) {
                $object = $callback[0];
                $method = $callback[1];
            } elseif (is_object($callback) && method_exists($callback, '__invoke')) {
                $object = $callback;
                $method = '__invoke';
            } else {
                $object = null;
                $method = $callback;
            }

            $method = isset($object)
            ? self::reflectMethod($object, $method)
            : self::reflectMethod($method);

            return self::invokeMethodArgs($method, $object, $arguments);
        }

        $function = self::reflectCallback($callback);

        return self::invokeFunctionArgs($function, $arguments);
    }

    /**
     * @param  array<mixed>  $arguments
     */
    public static function invokeMethodArgs(ReflectionMethod $method, ?object $object = null, array $arguments = []): mixed
    {
        $argv = self::resolveParameters($method, $arguments);
        /** @var mixed $result */
        $result = $method->invokeArgs($object, $argv);

        return self::resolveReturnType($method, $result);
    }

    /**
     * @param  array<mixed>  $arguments
     */
    public static function invokeFunctionArgs(ReflectionFunction $function, array $arguments = []): mixed
    {
        $argv = self::resolveParameters($function, $arguments);
        /** @var mixed $result */
        $result = $function->invokeArgs($argv);

        return self::resolveReturnType($function, $result);
    }

    /**
     * @param array<object|string>|string|callable(mixed ...$args): mixed $callback
     */
    public static function reflectCallback(array|string|callable $callback): ReflectionFunction
    {
        if (! is_callable($callback)) {
            throw ReflectorException::create('The callback must be callable.');
        }

        return self::reflectFunction(Closure::fromCallable($callback));
    }

    public static function reflectFunction(Closure|string $function): ReflectionFunction
    {
        return new ReflectionFunction($function);
    }

    public static function reflectMethod(object|string $object_or_method, string $method = null): ReflectionMethod
    {
        if (is_object($object_or_method) && is_string($method)) {
            return new ReflectionMethod($object_or_method, $method);
        }

        if (is_null($method) && is_string($object_or_method)) {
            return new ReflectionMethod($object_or_method);
        }

        throw ReflectorException::create('Cannot reflect a null or object method.');
    }

    public static function reflectReturnType(ReflectionFunctionAbstract $function): ?ReflectionType
    {
        if ($function->hasTentativeReturnType()) {
            return $function->getTentativeReturnType();
        }

        if ($function->hasReturnType()) {
            return $function->getReturnType();
        }

        return null;
    }

    public static function reflectProperty(object|string $class, string $property): ReflectionProperty
    {
        return new ReflectionProperty($class, $property);
    }

    public static function getPropertyValue(object $object, string $name): mixed
    {
        $property = self::reflectProperty($object, $name);
        if ($property->isInitialized($object)) {
            return $property->getValue($object);
        }
        if ($property->hasDefaultValue()) {
            return $property->getValue($object);
        }
        throw ReflectorException::create('Cannot get property %s', [$name]);
    }

    public static function setPropertyValue(object $object, string $name, mixed $value): void
    {
        $property = self::reflectProperty($object, $name);

        if (null !== ($type = $property->getType()) && ! self::checkType($type, $value)) {
            throw ReflectorException::create('Property %s has invalid type.', [$name]);
        }

        $property->setValue($object, $value);
    }

    /**
     * @param  array<mixed>  $arguments
     * @return array<mixed>
     */
    public static function resolveParameters(ReflectionFunctionAbstract $function, array $arguments = []): array
    {
        /** @var array<mixed> $values */
        $values = [];
        $key = 0;
        foreach ($function->getParameters() as $parameter) {
            $name = $parameter->getName();
            /** @var mixed $value */
            $value = $arguments[$name] ?? $arguments[$key] ?? null;

            if (is_null($value)) {
                if (! $parameter->isOptional()) {
                    throw ReflectorException::create('Parameter %s value is required.', [$name]);
                }

                /** @var mixed $value */
                $value = $parameter->getDefaultValue();
            }

            /** @var mixed $value */
            $value = self::resolveValue($value);

            if (null !== ($type = $parameter->getType()) && ! self::checkType($type, $value)) {
                throw ReflectorException::create('Parameter %s has invalid type.', [$name]);
            }

            $values[] = $value;
            $key++;
        }

        return $values;
    }

    public static function resolveReturnType(ReflectionFunctionAbstract $function, mixed $value): mixed
    {
        $type = self::reflectReturnType($function);

        if (is_null($type)) {
            return null;
        }

        if (! self::checkType($type, $value)) {
            throw ReflectorException::create('Bad return type');
        }

        return self::resolveValue($value);
    }

    public static function resolveValue(mixed $value): mixed
    {
        return $value;
    }

    public static function checkType(ReflectionType $type, mixed $value): bool
    {
        if (is_null($value)) {
            return $type->allowsNull();
        }

        if ($type instanceof ReflectionNamedType) {
            return self::checkNamedType($type, $value);
        }

        if (
            class_exists(ReflectionIntersectionType::class, false)
            && $type instanceof ReflectionIntersectionType
        ) {
            return self::checkIntersectionType($type, $value);
        }
        if (! class_exists(ReflectionUnionType::class, false)) {
            return false;
        }
        if (! $type instanceof ReflectionUnionType) {
            return false;
        }

        return self::checkUnionType($type, $value);
    }

    public static function checkNamedType(ReflectionNamedType $type, mixed $value): bool
    {
        $name = $type->getName();

        if ($name === 'mixed') {
            return true;
        }

        if ($type->isBuiltin()) {
            return $name === gettype($value);
        }

        return $value instanceof $name;
    }

    public static function checkIntersectionType(ReflectionIntersectionType $type, mixed $value): bool
    {
        /** @var ReflectionNamedType $t */
        foreach ($type->getTypes() as $t) {
            if (! self::checkNamedType($t, $value)) {
                return false;
            }
        }

        return true;
    }

    public static function checkUnionType(ReflectionUnionType $type, mixed $value): bool
    {
        foreach ($type->getTypes() as $t) {
            if (self::checkNamedType($t, $value)) {
                return true;
            }
        }

        return false;
    }

    public static function isMethod(mixed $callback): bool
    {
        if (! is_callable($callback)) {
            return false;
        }

        if (is_string($callback) && str_contains($callback, '::')) {
            return true;
        }

        if (is_array($callback)) {
            return true;
        }

        if (! is_object($callback)) {
            return false;
        }

        return method_exists($callback, '__invoke');
    }
}
