<?php

namespace Sikessem\Capsule;

trait Getter {
    public function __get(string $name): mixed {
        if (method_exists($this, $before_method = 'getting' . ucfirst($name))) {
            $this->$before_method();
        }
        if (method_exists($this, $method = 'get' . ucfirst($name))) {
            $result = $this->$method();
        }
        else if (property_exists($this, $name)) {
            $result = $this->$name;
        }
        else {
            throw new \RuntimeException('Property ' . $name . ' not found');
        }
        if (method_exists($this, $after_method = 'getted' . ucfirst($name))) {
            $this->$after_method();
        }
        return $result;
    }

    public function __isset(string $name): bool {
        if (method_exists($this, $method = 'get' . ucfirst($name)) && $this->$method() !== null) {
            return true;
        }
        return property_exists($this, $name) && isset($this->$name);
    }
}