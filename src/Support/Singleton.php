<?php

namespace Sikessem\Capsule\Support;

final class Singleton
{
    private static ?Container $container = null;

    private function __construct()
    {
    }

    public static function getContainer(): Container
    {
        if (! isset(self::$container)) {
            self::$container = new Container;
        }

        return self::$container;
    }
}
