<?php

namespace Sikessem\Capsule\Exceptions;

use Psr\Container\NotFoundExceptionInterface;
use Sikessem\Capsule\Interfaces\Triggerable;
use Sikessem\Capsule\Traits\Trigger;

final class NotFoundException extends \Exception implements Triggerable, NotFoundExceptionInterface
{
    use Trigger;
}
