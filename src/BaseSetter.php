<?php

namespace Sikessem\Capsule;

use Sikessem\Capsule\Interfaces\IsModifiable;
use Sikessem\Capsule\Traits\HasModifier;

/**
 * Allows you to modify class properties dynamically
 */
abstract class BaseSetter implements IsModifiable
{
    use HasModifier;
}
