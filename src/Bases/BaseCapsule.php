<?php

namespace Sikessem\Capsule\Bases;

use Sikessem\Capsule\Interfaces\IsAccessible;
use Sikessem\Capsule\Interfaces\IsModifiable;
use Sikessem\Capsule\Traits\HasAccessor;
use Sikessem\Capsule\Traits\HasModifier;

/**
 * Allows access to modify the properties of the class dynamically
 */
abstract class BaseCapsule implements IsAccessible, IsModifiable
{
    use HasAccessor, HasModifier;
}
