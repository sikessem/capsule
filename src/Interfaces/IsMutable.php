<?php

namespace Sikessem\Capsule\Interfaces;

interface IsMutable
{
    /**
     * Allows you to modify a property
     *
     * @throws ExceptionType When property is not defined
     */
    public function __set(string $name, mixed $value): void;

    /**
     * Allows you to delete a property
     */
    public function __unset(string $name): void;
}
