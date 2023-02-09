<?php

namespace Sikessem\Capsule;

use Sikessem\Capsule\Exception\NotFound;
use Sikessem\Capsule\Support\Singleton;

trait HasResolver
{
    /**
     * @var array<string,array<object|string>|string|object|callable(mixed ...$args): mixed>
     */
    protected array $actions = [];

    /**
     * @var array<string,array<object|string>|string|object|callable(mixed ...$args): mixed>
     */
    protected static array $ACTIONS = [];

    /**
     * @param array<object|string>|string|object|callable(mixed ...$args): mixed $action
     */
    public function on(string $name, $action): static
    {
        $this->actions[$name] = $action;

        return $this;
    }

    /**
     * @param array<object|string>|string|object|callable(mixed ...$args): mixed $action
     */
    public static function onStatic(string $name, $action): void
    {
        self::$ACTIONS[$name] = $action;
    }

    /**
     * Allows you to call actions
     *
     * @param  array<mixed>  $args
     *
     * @throws NotFound When action is not defined
     */
    public function resolve(string $name, array $args = []): mixed
    {
        foreach ($this->actions as $_name => $action) {
            if ($_name == $name) {
                return Singleton::getContainer()->invoke($action, ...$args);
            }
        }

        throw NotFound::with('Could not find action %s.', [$name]);
    }

    /**
     * Allows to call static actions
     *
     * @param  array<mixed>  $args
     *
     * @throws NotFound When action is not defined
     */
    public static function resolveStatic(string $name, array $args = []): mixed
    {
        foreach (static::$ACTIONS as $_name => $action) {
            if ($_name === $name) {
                return Singleton::getContainer()->invoke($action, ...$args);
            }
        }

        throw NotFound::with('Could not find static action %s.', [$name]);
    }

    /**
     * @param  array<mixed>  $args
     */
    public function __call(string $name, array $args = []): mixed
    {
        return $this->resolve($name, $args);
    }

    /**
     * @param  array<mixed>  $args
     */
    public static function __callStatic(string $name, array $args = []): mixed
    {
        return static::resolveStatic($name, $args);
    }
}
