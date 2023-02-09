<?php

namespace Sikessem\Capsule\Tests;

use Sikessem\Capsule\Exception\NotFound;
use Sikessem\Capsule\IsAccessible;
use Sikessem\Capsule\IsEncapsulated;
use Sikessem\Capsule\IsModifiable;
use Sikessem\Capsule\IsResolvable;
use Sikessem\Capsule\Sample\CustomClass;
use Sikessem\Capsule\Support\Container;

beforeEach(function () {
    $this->capsule = new CustomClass('Sikessem');
});

it('should be encapsulated', function () {
    expect($this->capsule)
    ->toBeInstanceOf(IsEncapsulated::class)
    ->toBeInstanceOf(IsAccessible::class)
    ->toBeInstanceOf(IsModifiable::class)
    ->toBeInstanceOf(IsResolvable::class);
});

it('should be resolvable', function () {
    $hello = fn (?string $name = null) => 'Hello '.($name ?? 'Sikessem').'!';
    CustomClass::onStatic('hello', $hello);
    $this->capsule->on('hello', $hello);

    expect(CustomClass::hello())
    ->toEqual($this->capsule->hello())
    ->toEqual('Hello Sikessem!');
});

it('should set and get name', function () {
    $capsule = $this->capsule;
    $capsule->name = 'Capsule';

    expect($capsule->name)
    ->toEqual('Capsule');
});

it('throws a not found exception when not encapsulable', function () {
    expect(fn () => $this->capsule->age)
    ->toThrow(NotFound::class, 'Unable to get property age.');

    expect(fn () => $this->capsule->age = 22)
    ->toThrow(NotFound::class, 'Unable to set property age.');

    expect(fn () => $this->capsule->hi())
    ->toThrow(NotFound::class, 'Could not find action hi.');

    expect(fn () => CustomClass::hi())
    ->toThrow(NotFound::class, 'Could not find static action hi.');
});

it('should provide the components', function () {
    $c = new Container([
        'class' => CustomClass::class,
        CustomClass::class => [
            'name' => 'Sikessem',
            'year' => date('Y'),
        ],
        CustomInterface::class => new CustomClass(),
    ]);

    expect($c)->toBeInstanceOf(Container::class);
    expect($class = $c->get('class'))->toBeInstanceOf(CustomClass::class);
    expect($interface = $c->get(CustomInterface::class))->toBeInstanceOf(CustomClass::class);
    expect($class->getName())->toEqual('Sikessem');
    expect($interface->getName())->toEqual('World');
});
