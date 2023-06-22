<?php

namespace Sikessem\Capsule\Core;

use Sikessem\Capsule\Exception\NotFound;
use Sikessem\Capsule\Support\Reflector;
use Sikessem\Capsule\Support\Singleton;

trait HasModifier
{
    /**
     * Modify the value of an object's properties using set methods
     *
     * @throws NotFound When property is not defined
     */
    public function __set(string $name, mixed $value): void
    {
        if (method_exists($this, $method = 'set'.ucfirst($name))) {
            Singleton::getContainer()->invoke([$this, $method], $value);
        } elseif (property_exists($this, $name)) {
            Reflector::setPropertyValue($this, $name, $value);
        } else {
            throw NotFound::with('Unable to set property %s.', [$name]);
        }
    }

    /**
     * Remove the value of an object's properties using set methods
     */
    public function __unset(string $name): void
    {
        if (method_exists($this, $method = 'set'.ucfirst($name))) {
            Singleton::getContainer()->invoke([$this, $method], null);
        } elseif (property_exists($this, $name)) {
            unset($this->$name);
        }
    }
}
