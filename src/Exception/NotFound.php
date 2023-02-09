<?php

namespace Sikessem\Capsule\Exception;

final class NotFound extends \InvalidArgumentException implements IsNotFound
{
    use HasExceptionConstructor;
}
