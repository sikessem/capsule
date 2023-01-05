<?php

namespace Sikessem\Capsule\Exceptions;

use Sikessem\Capsule\Interfaces\ExceptionInterface;
use Sikessem\Capsule\Traits\HasTrigger;

final class ReflectorException extends \ReflectionException implements ExceptionInterface
{
    use HasTrigger;
}
