<?php

namespace Sikessem\Capsule\Traits;

trait HasMutator
{
    public function __set(string $name, mixed $value): void
    {
        if (method_exists($this, $before_method = 'setting'.ucfirst($name))) {
            $this->$before_method($name, $value);
        }
        if (method_exists($this, $method = 'set'.ucfirst($name))) {
            $this->$method($value);
        } elseif (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new \RuntimeException('Property '.$name.' not found');
        }
        if (method_exists($this, $after_method = 'setted'.ucfirst($name))) {
            $this->$after_method($name, $value);
        }
    }

    public function __unset(string $name): void
    {
        if (method_exists($this, $method = 'set'.ucfirst($name))) {
            $this->$method(null);
        } elseif (property_exists($this, $name)) {
            unset($this->$name);
        }
    }
}
