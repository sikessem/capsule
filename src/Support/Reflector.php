<?php

namespace Sikessem\Capsule\Support;

use Closure;
use ReflectionClass;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionProperty;
use ReflectionType;
use ReflectionUnionType;
use Sikessem\Capsule\Exceptions\ReflectorException;

final class Reflector
{
    /**
     * @template TObject of object
     *
     * @param  TObject|class-string<TObject>  $object_or_class
     * @return ReflectionClass<TObject>
     */
    public static function reflectClass(object|string $object_or_class): ReflectionClass
    {
        return new ReflectionClass($object_or_class);
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

    /**
     * @param array<object|string>|string|object|callable(mixed ...$args): mixed $function
     */
    public static function reflectFunctionParameter(string|array|object|callable $function, int|string $position): ReflectionParameter
    {
        return new ReflectionParameter($function, $position);
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
     * @param  mixed[]  $args
     * @return mixed[]
     */
    public static function buildFunctionArgs(ReflectionFunctionAbstract $func, array $args = []): array
    {
        return self::buildParametersValues($func->getParameters(), $args);
    }

    /**
     * @param  list<ReflectionParameter>  $params
     * @param  mixed[]  $args
     * @return mixed[]
     */
    public static function buildParametersValues(array $params, array $args): array
    {
        /** @var mixed[] $values */
        $values = [];
        foreach ($params as $param) {
            /** @var mixed $value */
            $value = self::buildParameterValue($param, $args);
            /** @psalm-suppress MixedAssignment */
            $values[] = $value;
        }

        return $values;
    }

    public static function buildParameterValue(ReflectionParameter $param, array $args = []): mixed
    {
        $name = $param->getName();
        $position = $param->getPosition();

        /** @var mixed $value */
        $value = $args[$name] ?? $args[$position] ?? null;

        if (is_null($value) && $param->isOptional()) {
            /** @var mixed $value */
            $value = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
        }

        return $value;
    }

    public static function checkType(?ReflectionType $type, mixed $value): bool
    {
        if (null === $type) {
            return true;
        }

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

    /**
     * @param  list<class-string>  $classes
     */
    public static function getParameterClassName(ReflectionParameter $param, array $classes = []): ?string
    {
        $type = $param->getType();

        if (! $type instanceof ReflectionType) {
            return null;
        }

        return self::getParameterClassNameByType($type, $param, $classes);
    }

    /**
     * @param  list<class-string>  $classes
     */
    public static function getParameterClassNameByType(ReflectionType $type, ReflectionParameter $param, array $classes = []): ?string
    {
        if ($type instanceof ReflectionNamedType) {
            return self::getParameterClassNameByNamedType($type, $param, $classes);
        }

        if ($type instanceof ReflectionUnionType) {
            return self::getParameterClassNameByUnionType($type, $param, $classes);
        }

        if ($type instanceof ReflectionIntersectionType) {
            return self::getParameterClassNameByIntersectionType($type, $param, $classes);
        }

        return null;
    }

    /**
     * @param  list<class-string>  $classes
     */
    public static function getParameterClassNameByNamedType(ReflectionNamedType $type, ReflectionParameter $param, array $classes = []): ?string
    {
        if ($type->isBuiltin()) {
            return null;
        }

        /** @var string|class-string|trait-string $name */
        $name = $type->getName();

        if (($class = $param->getDeclaringClass()) instanceof ReflectionClass) {
            if ($name === 'self') {
                return $class->getName();
            }

            if ($name === 'parent' && ($parent = $class->getParentClass()) instanceof ReflectionClass) {
                return $parent->getName();
            }
        }

        if (class_exists($name) || interface_exists($name)) {
            foreach ($classes as $class) {
                if ($class instanceof $name) {
                    return $class;
                }
            }
        }

        return $name;
    }

    /**
     * @param  list<class-string>  $classes
     */
    public static function getParameterClassNameByUnionType(ReflectionUnionType $type, ReflectionParameter $param, array $classes = []): ?string
    {
        foreach ($type->getTypes() as $t) {
            if ($class = self::getParameterClassNameByType($t, $param, $classes)) {
                return $class;
            }
        }

        return null;
    }

    /**
     * @param  list<class-string>  $classes
     */
    public static function getParameterClassNameByIntersectionType(ReflectionIntersectionType $type, ReflectionParameter $param, array $classes = []): ?string
    {
        foreach ($type->getTypes() as $t) {
            while ($classes !== [] && ($class = self::getParameterClassNameByType($t, $param, $classes))) {
                if (self::checkIntersectionType($type, $class)) {
                    return $class;
                }

                if (false !== ($key = array_search($class, $classes, true))) {
                    array_splice($classes, $key, 1);
                }
            }
        }

        return null;
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
            if (self::checkType($t, $value)) {
                return true;
            }
        }

        return false;
    }
}
