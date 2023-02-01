<?php

namespace Sikessem\Capsule\Bases;

use Sikessem\Capsule\Interfaces\Resolvable;
use Sikessem\Capsule\Traits\Resolver;

/**
 * Allows you to modify class properties dynamically
 */
abstract class BaseCaller implements Resolvable
{
    use Resolver;
}
