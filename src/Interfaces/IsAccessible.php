<?php

namespace Sikessem\Capsule\Interfaces;

interface IsAccessible
{
    public function __get(string $name): mixed;

    public function __isset(string $name): bool;
}
