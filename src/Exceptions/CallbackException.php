<?php

namespace Sikessem\Capsule\Exceptions;

use Sikessem\Capsule\Interfaces\Triggerable;
use Sikessem\Capsule\Traits\Trigger;

final class CallbackException extends \InvalidArgumentException implements Triggerable
{
    use Trigger;
}
