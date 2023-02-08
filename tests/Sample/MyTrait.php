<?php

namespace Sikessem\Capsule\Tests\Sample;

trait MyTrait
{
    protected string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
