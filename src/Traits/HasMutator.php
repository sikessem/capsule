<?php

namespace Sikessem\Capsule\Traits;

trait HasMutator
{
    /**
     * Modify the value of an object's properties using set methods
     */
    public function __set(string $name, mixed $value): void
    {
        if (method_exists($this, $method = 'set'.ucfirst($name))) {
            $this->$method($value);
        } elseif (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new \RuntimeException('Property '.$name.' not found');
        }
    }

    /**
     * Remove the value of an object's properties using set methods
     */
    public function __unset(string $name): void
    {
        if (method_exists($this, $method = 'set'.ucfirst($name))) {
            $this->$method(null);
        } elseif (property_exists($this, $name)) {
            unset($this->$name);
        }
    }
}
