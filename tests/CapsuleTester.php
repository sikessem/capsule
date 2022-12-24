<?php

namespace Sikessem\Capsule\Tests;

use RuntimeException;
use Sikessem\Capsule\Encapsulable;
use Sikessem\Capsule\Gettable;
use Sikessem\Capsule\Settable;

beforeEach(function () {
    $this->capsule = new Capsule();
});

it('should be an instance of Gettable, Settable and Encapsulable', function () {
    expect($this->capsule)
    ->toBeInstanceOf(Gettable::class)
    ->toBeInstanceOf(Settable::class)
    ->toBeInstanceOf(Encapsulable::class);
});

it('should set and get property from defined setter and getter', function () {
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

    $capsule->myProperty = 'My Capsule';

    expect($capsule->myProperty)
    ->toEqual('My Capsule');
});

it('throws a runtime exception when an unsupported property is accessed', function () {
    expect(fn () => $this->capsule->getProperty)
    ->toThrow(RuntimeException::class, 'Property getProperty not found');
});

it('throws a runtime exception when mutating an unsupported property', function () {
    expect(fn () => $this->capsule->setProperty = 'property')
    ->toThrow(RuntimeException::class, 'Property setProperty not found');
});
