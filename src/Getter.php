<?php

namespace Sikessem\Capsule;

use Sikessem\Capsule\Interfaces\IsAccessible;
use Sikessem\Capsule\Traits\HasAccessor;

abstract class Getter implements IsAccessible
{
    use HasAccessor;
}
