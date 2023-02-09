<?php

namespace Sikessem\Capsule\Exception;

final class BadValue extends \UnexpectedValueException implements IsException
{
    use HasExceptionConstructor;
}
