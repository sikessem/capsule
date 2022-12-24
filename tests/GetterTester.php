<?php

namespace Sikessem\Capsule\Tests;

use RuntimeException;
use Sikessem\Capsule\Getter;
use Sikessem\Capsule\Interfaces\IsAccessible;

beforeEach(function () {
    $this->getter = new class() extends Getter
    {
    };
});

it('should be accessible', function () {
    expect($this->getter)
    ->toBeInstanceOf(IsAccessible::class);
});

it('throws a runtime exception when an unsupported property is accessed', function () {
    expect(fn () => $this->getter->getProperty)
    ->toThrow(RuntimeException::class, 'Property getProperty not found');
});
