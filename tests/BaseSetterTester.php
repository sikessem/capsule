<?php

namespace Sikessem\Capsule\Tests;

use Sikessem\Capsule\Bases\BaseSetter;
use Sikessem\Capsule\Exceptions\SetterException;
use Sikessem\Capsule\Interfaces\Modifiable;

beforeEach(function () {
    $this->setter = new class() extends BaseSetter
    {
    };
});

it('should be accessible', function () {
    expect($this->setter)
    ->toBeInstanceOf(Modifiable::class);
});

it('throws a SetterException when mutating an unsupported property', function () {
    expect(fn () => $this->setter->setProperty = 'property')
    ->toThrow(SetterException::class, 'Unable to set property setProperty.');
});
