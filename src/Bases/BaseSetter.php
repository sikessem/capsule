<?php

namespace Sikessem\Capsule\Bases;

use Sikessem\Capsule\Interfaces\Modifiable;
use Sikessem\Capsule\Traits\Modifier;

/**
 * Allows you to modify class properties dynamically
 */
abstract class BaseSetter implements Modifiable
{
    use Modifier;
}
