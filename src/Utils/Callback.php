<?php

namespace Sikessem\Capsule\Utils;

use Closure;
use Sikessem\Capsule\Exceptions\CallbackException;

final class Callback
{
    /**
     * @param array<object|string>|string|object|callable(mixed ...$args): mixed $value
     */
    public function __construct(array|string|object|callable $value)
    {
        $this->setValue($value);
    }

    /**
     * @param array<object|string>|string|object|callable(mixed ...$args): mixed $value
     */
    public static function from(array|string|object|callable $value): self
    {
        return new self($value);
    }

    /**
     * @var array<object|string>|string|object|callable(mixed ...$args): mixed
     */
    private $value;

    /**
     * @param array<object|string>|string|object|callable(mixed ...$args): mixed $value
     */
    public function setValue(array|string|object|callable $value): static
    {
        if (! is_callable($value)) {
            throw CallbackException::create('The callback value must be callable.');
        }

        if (
            is_string($value)
            && str_contains($value, '::')
        ) {
            $info = explode('::', $value);
            $this->class = $info[0];
            $this->method = $info[1];
        } elseif (
            is_array($value)
            && is_object($value[0])
            && is_string($value[1])
        ) {
            $this->object = $value[0];
            $this->method = $value[1];
        } elseif (
            is_object($value)
            && method_exists($value, '__invoke')
        ) {
            $this->object = $value;
            $this->method = '__invoke';
        } else {
            $this->function = $value;
        }

        $this->value = $value;

        return $this;
    }

    /**
     * @return array<object|string>|string|object|callable(mixed ...$args): mixed
     */
    public function getValue(): array|string|object|callable
    {
        return $this->value;
    }

    private ?string $class = null;

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function hasClass(): bool
    {
        return isset($this->class);
    }

    private ?object $object = null;

    public function getObject(): ?object
    {
        return $this->object;
    }

    public function hasObject(): bool
    {
        return isset($this->object);
    }

    private ?string $method = null;

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function isMethod(): bool
    {
        return isset($this->method);
    }

    /**
     * @var null|string|callable(mixed ...$args): mixed
     */
    private $function;

    /**
     * @return null|string|callable(mixed ...$args): mixed
     */
    public function getFunction(): null|string|callable
    {
        return $this->function;
    }

    public function isFunction(): bool
    {
        return $this->function !== null;
    }

    public function toClosure(): Closure
    {
        if (! is_callable($this->value)) {
            throw CallbackException::create('The callback value must be callable.');
        }

        return Closure::fromCallable($this->value);
    }
}
