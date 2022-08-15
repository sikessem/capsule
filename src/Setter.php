<?php

namespace Sikessem\Capsule;

trait Setter {
    public function __set(string $name, mixed $value): void {
        if (method_exists($this, $method = 'set' . ucfirst($name))) {
            if (method_exists($this, $before_method = 'setting' . ucfirst($name))) {
                $this->$before_method($name, $value);
            }
            $this->$method($value);
            if (method_exists($this, $after_method = 'setted' . ucfirst($name))) {
                $this->$after_method($name, $value);
            }
        } else {
            throw new \RuntimeException('Property ' . $name . ' not found');
        }
    }

    public function __unset(string $name): void {
        if (method_exists($this, $method = 'set' . ucfirst($name))) {
            $this->$method(null);
        }
    }
}