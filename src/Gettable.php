<?php

namespace Sikessem\Capsule;

interface Gettable {
    public function __get(string $name): mixed;
    public function __isset(string $name): bool;
}