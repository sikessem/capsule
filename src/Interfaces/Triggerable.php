<?php

namespace Sikessem\Capsule\Interfaces;

use Throwable;

interface Triggerable extends Throwable
{
    /**
     * @param  array<string|int>  $arguments
     * @param  ?Throwable  $previous
     */
    public static function create(string $message = '', array $arguments = [], int $code = 0, Throwable $previous = null): Throwable;
}
