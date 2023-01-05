<?php

namespace Sikessem\Capsule\Exceptions;

use Sikessem\Capsule\Interfaces\ExceptionInterface;
use Sikessem\Capsule\Traits\HasTrigger;

final class SetterException extends \BadMethodCallException implements ExceptionInterface
{
    use HasTrigger;
}
