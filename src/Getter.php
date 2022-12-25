<?php

namespace Sikessem\Capsule;

use Sikessem\Capsule\Interfaces\IsAccessible;
use Sikessem\Capsule\Traits\HasAccessor;

/**
 * Provides access to class properties dynamically
 */
abstract class Getter implements IsAccessible
{
    use HasAccessor;
}
