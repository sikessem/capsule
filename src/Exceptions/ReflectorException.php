<?php

namespace Sikessem\Capsule\Exceptions;

use Sikessem\Capsule\Interfaces\Triggerable;
use Sikessem\Capsule\Traits\Trigger;

final class ReflectorException extends \ReflectionException implements Triggerable
{
    use Trigger;
}
