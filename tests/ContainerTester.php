<?php

use Sikessem\Capsule\Support\Container;
use Sikessem\Capsule\Tests\Sample\MyClass;
use Sikessem\Capsule\Tests\Sample\MyInterface;

test('capsule', function () {
    $c = new Container([
        'class' => MyClass::class,
        MyClass::class => [
            'name' => 'Sikessem',
            'year' => date('Y'),
        ],
        MyInterface::class => new MyClass(),
    ]);

    expect($c)->toBeInstanceOf(Container::class);
    expect($class = $c->get('class'))->toBeInstanceOf(MyClass::class);
    expect($interface = $c->get(MyInterface::class))->toBeInstanceOf(MyClass::class);
    expect($class->getName())->toEqual('Sikessem');
    expect($interface->getName())->toEqual('World');
});
