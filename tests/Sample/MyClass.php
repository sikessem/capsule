<?php

namespace Sikessem\Capsule\Tests\Sample;

class MyClass implements MyInterface
{
    use MyTrait;

    public function __construct(string $name = 'World')
    {
        $this->setName($name);
    }
}
