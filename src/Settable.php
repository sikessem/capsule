<?php

namespace Sikessem\Capsule;

interface Settable {
    public function __set(string $name, mixed $value): void;
    public function __unset(string $name): void;
}