<?php

namespace Sikessem\Capsule\Tests;

use Sikessem\Capsule\Bases\BaseCapsule;

class TestCapsule extends BaseCapsule
{
    private mixed $property = 'default value';

    public function getProperty(): mixed
    {
        return 'get'.$this->property;
    }

    public function setProperty(mixed $value)
    {
        $this->property = 'set'.$value;
    }

    protected mixed $myProperty = 'My default value';
}
