<?php

namespace App;

use Sikessem\Capsule\{Encapsulable, Encapsuler};

class Capsule implements Encapsulable {
    use Encapsuler;

    // The property to encapsulate must be defined if it has no getter/setter method.
    private mixed $property = 'default value';

    // No need to define this method if the property to get is defined.
    public function getProperty(): mixed {
        return $this->property;
    }

    // No need to define this method if it has no action to perform before getting the property
    public function gettingProperty(): void {
        // The action to perform before getting the property
        echo 'Getting property...' . PHP_EOL;
    }

    // No need to define this method if it has no action to perform after getted the property
    public function gettedProperty(): void {
        // The action to perform after getted the property
        echo 'Getted property...' . PHP_EOL;
    }

    // No need to define this method if the property to set is defined.
    public function setProperty(mixed $value) {
        $this->property = $value;
    }

    // No need to define this method if it has no action to perform before setting the property
    public function settingProperty(mixed $value): void {
        // The action to perform before setting the property
        echo 'Setting property...' . PHP_EOL;
    }

    // No need to define this method if it has no action to perform after setted the property
    public function settedProperty(mixed $value): void {
        // The action to perform after setted the property
        echo 'Setted property...' . PHP_EOL;
    }
}