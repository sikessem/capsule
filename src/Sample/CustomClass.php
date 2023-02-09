<?php

namespace Sikessem\Capsule\Sample;

final class CustomClass implements CustomInterface
{
    use CustomTrait;

    public function __construct(string $name = 'World')
    {
        $this->setName($name);
    }
}
