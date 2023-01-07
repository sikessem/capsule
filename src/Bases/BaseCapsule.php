<?php

namespace Sikessem\Capsule\Bases;

use Sikessem\Capsule\Interfaces\Accessible;
use Sikessem\Capsule\Interfaces\Modifiable;
use Sikessem\Capsule\Traits\Accessor;
use Sikessem\Capsule\Traits\Modifier;

/**
 * Allows access to modify the properties of the class dynamically
 */
abstract class BaseCapsule implements Accessible, Modifiable
{
    use Accessor, Modifier;
}
