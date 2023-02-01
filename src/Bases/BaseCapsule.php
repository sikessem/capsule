<?php

namespace Sikessem\Capsule\Bases;

use Sikessem\Capsule\Interfaces\Accessible;
use Sikessem\Capsule\Interfaces\Modifiable;
use Sikessem\Capsule\Interfaces\Resolvable;
use Sikessem\Capsule\Traits\Accessor;
use Sikessem\Capsule\Traits\Modifier;
use Sikessem\Capsule\Traits\Resolver;

/**
 * Allows access to modify the properties of the class dynamically
 */
abstract class BaseCapsule implements Accessible, Modifiable, Resolvable
{
    use Accessor, Modifier, Resolver;
}
