<?php

namespace Sikessem\Capsule;

use Sikessem\Capsule\Exception\IsNotFound;

interface IsAccessible
{
    /**
     * Provides access to a property
     *
     * @throws IsNotFound When property is not accessible
     */
    public function __get(string $name): mixed;

    /**
     * Checks if a property exists
     */
    public function __isset(string $name): bool;
}
