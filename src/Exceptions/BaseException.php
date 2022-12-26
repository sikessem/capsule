<?php

namespace Sikessem\Capsule\Exceptions;

use RuntimeException as Exception;
use Sikessem\Capsule\Interfaces\ExceptionType;

abstract class BaseException extends Exception implements ExceptionType
{
}
