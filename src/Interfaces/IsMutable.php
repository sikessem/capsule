<?php

namespace Sikessem\Capsule\Interfaces;

interface IsMutable
{
    /**
     * Allows you to modify a property
     */
    public function __set(string $name, mixed $value): void;

    /**
     * Allows you to delete a property
     */
    public function __unset(string $name): void;
}
