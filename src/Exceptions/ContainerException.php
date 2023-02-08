<?php

namespace Sikessem\Capsule\Exceptions;

use Psr\Container\ContainerExceptionInterface;
use Sikessem\Capsule\Interfaces\Triggerable;
use Sikessem\Capsule\Traits\Trigger;

final class ContainerException extends \ReflectionException implements Triggerable, ContainerExceptionInterface
{
    use Trigger;
}
