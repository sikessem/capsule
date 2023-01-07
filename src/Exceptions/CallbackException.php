<?php

namespace Sikessem\Capsule\Exceptions;

use Sikessem\Capsule\Interfaces\ExceptionInterface;
use Sikessem\Capsule\Traits\HasTrigger;

final class CallbackException extends \InvalidArgumentException implements ExceptionInterface
{
    use HasTrigger;
}
