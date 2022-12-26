<?php

namespace Sikessem\Capsule\Interfaces;

interface ExceptionType extends \Throwable
{
    public static function create(string $property): static;
}
