<?php

namespace Sikessem\Capsule\Interfaces;

interface Resolvable
{
    /**
     * Allows you to call actions
     *
     * @param  array<mixed>  $args
     *
     * @throws Triggerable When action is not defined
     */
    public function __call(string $name, array $args = []): mixed;

    /**
     * Allows to call static actions
     *
     * @param  array<mixed>  $args
     *
     * @throws Triggerable When action is not defined
     */
    public static function __callStatic(string $name, array $args = []): mixed;
}
