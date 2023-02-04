<?php

namespace Sikessem\Capsule\Traits;

use Sikessem\Capsule\Exceptions\SetterException;
use Sikessem\Capsule\Support\Reflector;

trait Modifier
{
    /**
     * Modify the value of an object's properties using set methods
     *
     * @throws SetterException When property is not defined
     */
    public function __set(string $name, mixed $value): void
    {
        if (method_exists($this, $method = 'set'.ucfirst($name))) {
            Reflector::invoke([$this, $method], $value);
        } elseif (property_exists($this, $name)) {
            Reflector::setPropertyValue($this, $name, $value);
        } else {
            throw SetterException::create('Unable to set property %s.', [$name]);
        }
    }

    /**
     * Remove the value of an object's properties using set methods
     */
    public function __unset(string $name): void
    {
        if (method_exists($this, $method = 'set'.ucfirst($name))) {
            Reflector::invoke([$this, $method], null);
        } elseif (property_exists($this, $name)) {
            unset($this->$name);
        }
    }
}
