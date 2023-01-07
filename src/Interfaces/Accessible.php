<?php

namespace Sikessem\Capsule\Interfaces;

interface Accessible
{
    /**
     * Provides access to a property
     *
     * @throws Triggerable When property is not accessible
     */
    public function __get(string $name): mixed;

    /**
     * Checks if a property exists
     */
    public function __isset(string $name): bool;
}
