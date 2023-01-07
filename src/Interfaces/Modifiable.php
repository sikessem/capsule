<?php

namespace Sikessem\Capsule\Interfaces;

interface Modifiable
{
    /**
     * Allows you to modify a property
     *
     * @throws Triggerable When property is not defined
     */
    public function __set(string $name, mixed $value): void;

    /**
     * Allows you to delete a property
     */
    public function __unset(string $name): void;
}
