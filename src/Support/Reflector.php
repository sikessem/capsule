<?php

namespace Sikessem\Capsule\Support;

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
     * @param array<object|string>|string|object|callable(mixed ...$args): mixed $callback
     */
    public static function invoke(array|string|object|callable $callback, mixed ...$arguments): mixed
    {
        return self::invokeArgs($callback, $arguments);
    }

    /**
     * @param  array<object|string>|string|object|callable(mixed ...$args): mixed  $callback
     * @param  mixed[]  $arguments
     */
    public static function invokeArgs(array|string|object|callable $callback, array $arguments = []): mixed
    {
        $callback = Callback::from($callback);

        if ($method = $callback->getMethod()) {
            $method = ($object = $callback->getObject())
            ? self::reflectMethod($object, $method)
            : self::reflectMethod($method);

            return self::invokeMethodArgs($method, $object, $arguments);
        }

        $function = self::reflectCallback($callback);

        return self::invokeFunctionArgs($function, $arguments);
    }

    /**
     * @param  mixed[]  $arguments
     */
    public static function invokeMethodArgs(ReflectionMethod $method, ?object $object = null, array $arguments = []): mixed
    {
        $values = self::resolveInputs($method, $arguments);
        /** @var mixed $result */
        $result = $method->invokeArgs($object, $values);

        return self::resolveReturnType($method, $result);
    }

    /**
     * @param  mixed[]  $arguments
     */
    public static function invokeFunctionArgs(ReflectionFunction $function, array $arguments = []): mixed
    {
        $values = self::resolveInputs($function, $arguments);
        /** @var mixed $result */
        $result = $function->invokeArgs($values);

        return self::resolveReturnType($function, $result);
    }

    public static function reflectCallback(Callback $callback): ReflectionFunction
    {
        return self::reflectFunction($callback->toClosure());
    }

    /**
     * @param  Closure|callable-string  $function
     */
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

    /**
     * @param  mixed[]  $arguments
     * @return mixed[]
     */
    public static function resolveInputs(ReflectionFunctionAbstract $function, array $arguments = []): array
    {
        /** @var mixed[] $values */
        $values = [];
        foreach ($function->getParameters() as $parameter) {
            $name = $parameter->getName();
            $position = $parameter->getPosition();

            /** @var mixed $value */
            $value = $arguments[$name] ?? $arguments[$position] ?? null;

            if (is_null($value)) {
                if (! $parameter->isOptional()) {
                    throw ReflectorException::create('Parameter %s value is required.', [$name]);
                }

                /** @var mixed $value */
                $value = $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null;
            }

            /** @var mixed $value */
            $value = self::resolveValue($value);

            if (null !== ($type = $parameter->getType()) && ! self::checkType($type, $value)) {
                throw ReflectorException::create('Parameter %s has invalid type.', [$name]);
            }

            /** @psalm-suppress MixedAssignment */
            $values[] = $value;
        }

        return $values;
    }

    public static function resolveReturnType(ReflectionFunctionAbstract $function, mixed $value): mixed
    {
        $type = self::reflectReturnType($function);

        if (is_null($type)) {
            return $value;
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

        if ($type instanceof ReflectionIntersectionType) {
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
}
