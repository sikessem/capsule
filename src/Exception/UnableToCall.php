<?php

namespace Sikessem\Capsule\Exception;

final class UnableToCall extends \BadFunctionCallException implements IsException
{
    use HasExceptionConstructor;
}
