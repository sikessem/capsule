<?php

namespace Sikessem\Capsule\Tests;

use Sikessem\Capsule\Bases\BaseGetter;
use Sikessem\Capsule\Exceptions\GetterException;
use Sikessem\Capsule\Interfaces\Accessible;

beforeEach(function () {
    $this->getter = new class() extends BaseGetter
    {
    };
});

it('should be accessible', function () {
    expect($this->getter)
    ->toBeInstanceOf(Accessible::class);
});

it('throws a GetterException when an unsupported property is accessed', function () {
    expect(fn () => $this->getter->getProperty)
    ->toThrow(GetterException::class, 'Unable to get property getProperty.');
});
