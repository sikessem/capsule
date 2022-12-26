<?php

namespace Sikessem\Capsule\Tests;

use Sikessem\Capsule\BaseGetter;
use Sikessem\Capsule\Exceptions\GetterException;
use Sikessem\Capsule\Interfaces\IsAccessible;

beforeEach(function () {
    $this->getter = new class() extends BaseGetter
    {
    };
});

it('should be accessible', function () {
    expect($this->getter)
    ->toBeInstanceOf(IsAccessible::class);
});

it('throws a GetterException when an unsupported property is accessed', function () {
    expect(fn () => $this->getter->getProperty)
    ->toThrow(GetterException::class, 'Unable to get property getProperty.');
});