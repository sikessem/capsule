<?php

namespace Sikessem\Capsule\Traits;

use Sikessem\Capsule\Exceptions\GetterException;

trait HasAccessor
{
    /**
     * Access object properties using get methods or property value
     *
     * @throws GetterException When property is not accessible
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
            throw GetterException::create($name);
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
