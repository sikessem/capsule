<?php

namespace Sikessem\Capsule\Tests;

use Sikessem\Capsule\Exceptions\SetterException;
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

it('throws a SetterException when mutating an unsupported property', function () {
    expect(fn () => $this->setter->setProperty = 'property')
    ->toThrow(SetterException::class, 'Unable to set property setProperty.');
});
