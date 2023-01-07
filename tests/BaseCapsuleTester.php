<?php

namespace Sikessem\Capsule\Tests;

use Sikessem\Capsule\Interfaces\Accessible;
use Sikessem\Capsule\Interfaces\Modifiable;

beforeEach(function () {
    $this->capsule = new TestCapsule();
});

it('should be accessible and mutable', function () {
    expect($this->capsule)
    ->toBeInstanceOf(Accessible::class)
    ->toBeInstanceOf(Modifiable::class);
});

it('should set and get myProperty dynamically', function () {
    $capsule = $this->capsule;
    $capsule->myProperty = 'My Capsule';

    expect($capsule->myProperty)
    ->toEqual('My Capsule');
});

it('should set and get property dynamically', function () {
    $capsule = $this->capsule;
    $capsule->property = 'capsule';

    expect($capsule->property)
    ->toEqual($capsule->getProperty())
    ->toEqual('getsetcapsule');
});
