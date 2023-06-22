<?php

namespace Sikessem\Capsule\Sample;

use Sikessem\Capsule\Core\IsEncapsulated;

interface CustomInterface extends IsEncapsulated
{
    public function getName(): string;

    public function setName(string $name): static;
}
