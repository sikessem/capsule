<?php

namespace Sikessem\Capsule\Exception;

use Psr\Container\ContainerExceptionInterface;
use Throwable;

interface IsException extends ContainerExceptionInterface
{
    /**
     * @param  array<string|int>  $arguments
     * @param  ?Throwable  $previous
     */
    public static function with(string $message = '', array $arguments = [], int $code = 0, Throwable $previous = null): Throwable;
}
