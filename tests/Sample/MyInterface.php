<?php

namespace Sikessem\Capsule\Tests\Sample;

interface MyInterface
{
    public function getName(): string;

    public function setName(string $name): static;
}
