<?php

namespace Sikessem\Capsule;

trait Getter {
    public function __get(string $name): mixed {
        if (method_exists($this, $method = 'get' . ucfirst($name))) {
            if (method_exists($this, $before_method = 'getting' . ucfirst($name))) {
                $this->$before_method();
            }
            $result = $this->$method();
            if (method_exists($this, $after_method = 'getted' . ucfirst($name))) {
                $this->$after_method();
            }
            return $result;
        }
        throw new \RuntimeException('Property ' . $name . ' not found');
    }

    public function __isset(string $name): bool {
        if (method_exists($this, $method = 'get' . ucfirst($name))) {
            return true;
        }
        return false;
    }
}