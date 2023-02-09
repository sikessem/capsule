<?php

namespace Sikessem\Capsule\Exception;

use Psr\Container\NotFoundExceptionInterface;

interface IsNotFound extends IsException, NotFoundExceptionInterface
{
}
