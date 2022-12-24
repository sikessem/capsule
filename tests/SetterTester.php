<?php

namespace Sikessem\Capsule\Tests;

use RuntimeException;
use Sikessem\Capsule\Interfaces\IsMutable;
use Sikessem\Capsule\Setter;

beforeEach(function () {
    $this->setter = new class() extends Setter
    {
    };
});

it('should be accessible', function () {
    expect($this->setter)
    ->toBeInstanceOf(IsMutable::class);
});

it('throws a runtime exception when mutating an unsupported property', function () {
    expect(fn () => $this->setter->setProperty = 'property')
    ->toThrow(RuntimeException::class, 'Property setProperty not found');
});
