<?php

namespace Sikessem\Capsule\Exceptions;

use Sikessem\Capsule\Interfaces\Triggerable;
use Sikessem\Capsule\Traits\Trigger;

final class CallerException extends \BadMethodCallException implements Triggerable
{
    use Trigger;
}
