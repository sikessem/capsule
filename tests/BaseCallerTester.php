<?php

namespace Sikessem\Capsule\Tests;

use Sikessem\Capsule\Bases\BaseCaller;
use Sikessem\Capsule\Exceptions\CallerException;
use Sikessem\Capsule\Interfaces\Resolvable;

beforeEach(function () {
    $this->caller = new class() extends BaseCaller
    {
    };
});

it('should be resolvable', function () {
    expect($this->caller)
    ->toBeInstanceOf(Resolvable::class);

    $hello = fn (?string $name = null) => 'Hello '.($name ?? 'Sikessem').'!';
    BaseCaller::onStatic('hello', $hello);
    $this->caller->on('hello', $hello);

    expect(BaseCaller::hello())
    ->toEqual($this->caller->hello())
    ->toEqual('Hello Sikessem!');
});

it('throws a CallerException when calling undefined action', function () {
    expect(fn () => $this->caller->hi())
    ->toThrow(CallerException::class, 'Could not find action hi.');

    expect(fn () => BaseCaller::hi())
    ->toThrow(CallerException::class, 'Could not find static action hi.');
});
