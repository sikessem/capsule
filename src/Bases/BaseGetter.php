<?php

namespace Sikessem\Capsule\Bases;

use Sikessem\Capsule\Interfaces\Accessible;
use Sikessem\Capsule\Traits\Accessor;

/**
 * Provides access to class properties dynamically
 */
abstract class BaseGetter implements Accessible
{
    use Accessor;
}
