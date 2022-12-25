<?php

namespace Sikessem\Capsule\Traits;

trait HasAccessor
{
    /**
     * Access object properties using get methods or property value
     */
    public function __get(string $name): mixed
    {
        if (method_exists($this, $method = 'get'.ucfirst($name))) {
            /** @var mixed $result */
            $result = $this->$method();
        } elseif (property_exists($this, $name)) {
            /** @var mixed $result */
            $result = $this->$name;
        } else {
            throw new \RuntimeException('Property '.$name.' not found');
        }

        return $result;
    }

    /**
     * Check the existence of a property from get methods or property value
     */
    public function __isset(string $name): bool
    {
        if (method_exists($this, $method = 'get'.ucfirst($name)) && $this->$method() !== null) {
            return true;
        }

        return property_exists($this, $name) && isset($this->$name);
    }
}
