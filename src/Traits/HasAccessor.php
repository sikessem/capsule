<?php

namespace Sikessem\Capsule\Traits;

trait HasAccessor
{
    public function __get(string $name): mixed
    {
        if (method_exists($this, $before_method = 'getting'.ucfirst($name))) {
            $this->$before_method();
        }
        if (method_exists($this, $method = 'get'.ucfirst($name))) {
            /** @var mixed */
            $result = $this->$method();
        } elseif (property_exists($this, $name)) {
            /** @var mixed */
            $result = $this->$name;
        } else {
            throw new \RuntimeException('Property '.$name.' not found');
        }
        if (method_exists($this, $after_method = 'getted'.ucfirst($name))) {
            $this->$after_method();
        }

        return $result;
    }

    public function __isset(string $name): bool
    {
        if (method_exists($this, $method = 'get'.ucfirst($name)) && $this->$method() !== null) {
            return true;
        }

        return property_exists($this, $name) && isset($this->$name);
    }
}
