<?php

namespace Sikessem\Capsule\Interfaces;

interface IsAccessible
{
    /**
     * Provides access to a property
     */
    public function __get(string $name): mixed;

    /**
     * Checks if a property exists
     */
    public function __isset(string $name): bool;
}
