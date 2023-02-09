<?php

namespace Sikessem\Capsule\Exception;

final class CannotReflect extends \ReflectionException implements IsException
{
    use HasExceptionConstructor;
}
