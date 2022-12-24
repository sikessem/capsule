<?php

namespace Sikessem\Capsule\Tests;

use Sikessem\Capsule\Interfaces\IsAccessible;
use Sikessem\Capsule\Interfaces\IsMutable;

beforeEach(function () {
    $this->capsule = new TestCapsule();
});

it('should be accessible and mutable', function () {
    expect($this->capsule)
    ->toBeInstanceOf(IsAccessible::class)
    ->toBeInstanceOf(IsMutable::class);
});

it('should set and get myProperty dynamically', function () {
    $capsule = $this->capsule;
    $capsule->myProperty = 'My Capsule';

    expect($capsule->myProperty)
    ->toEqual('My Capsule');
});

it('should set and get property dynamically', function () {
    $capsule = $this->capsule;

    ob_start();
    $capsule->property = 'capsule';
    $setEventsContent = ob_get_clean();

    expect($setEventsContent)
    ->toStartWith('Setting property...'.PHP_EOL)
    ->toEndWith('Setted property...'.PHP_EOL);

    ob_start();
    expect($capsule->property)
    ->toEqual($capsule->getProperty())
    ->toEqual('capsule');
    $getEventsContent = ob_get_clean();

    expect($getEventsContent)
    ->toStartWith('Getting property...'.PHP_EOL)
    ->toEndWith('Getted property...'.PHP_EOL);
});
