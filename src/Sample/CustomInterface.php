<?php

namespace Sikessem\Capsule\Sample;

use Sikessem\Capsule\IsEncapsulated;

interface CustomInterface extends IsEncapsulated
{
    public function getName(): string;

    public function setName(string $name): static;
}
