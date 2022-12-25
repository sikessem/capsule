<?php

namespace Sikessem\Capsule;

use Sikessem\Capsule\Interfaces\IsMutable;
use Sikessem\Capsule\Traits\HasMutator;

/**
 * Allows you to modify class properties dynamically
 */
abstract class Setter implements IsMutable
{
    use HasMutator;
}
