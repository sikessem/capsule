<?php

namespace Sikessem\Capsule\Tests;

use Sikessem\Capsule\BaseSetter;
use Sikessem\Capsule\Exceptions\SetterException;
use Sikessem\Capsule\Interfaces\IsModifiable;

beforeEach(function () {
    $this->setter = new class() extends BaseSetter
    {
    };
});

it('should be accessible', function () {
    expect($this->setter)
    ->toBeInstanceOf(IsModifiable::class);
});

it('throws a SetterException when mutating an unsupported property', function () {
    expect(fn () => $this->setter->setProperty = 'property')
    ->toThrow(SetterException::class, 'Unable to set property setProperty.');
});
