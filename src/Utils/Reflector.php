<?php

namespace Sikessem\Capsule\Utils;

use Closure;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionMethod;
use ReflectionProperty;
use ReflectionType;
use Sikessem\Capsule\Exceptions\ReflectorException;

final class Reflector
{
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
}
