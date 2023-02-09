<?php

namespace Sikessem\Capsule\Sample;

use Sikessem\Capsule\HasEncapsulator;

trait CustomTrait
{
    use HasEncapsulator;

    protected string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
