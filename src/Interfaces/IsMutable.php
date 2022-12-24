<?php

namespace Sikessem\Capsule\Interfaces;

interface IsMutable
{
    public function __set(string $name, mixed $value): void;

    public function __unset(string $name): void;
}
