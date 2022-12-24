<?php

namespace Sikessem\Capsule;

use Sikessem\Capsule\Interfaces\IsAccessible;
use Sikessem\Capsule\Interfaces\IsMutable;
use Sikessem\Capsule\Traits\HasAccessor;
use Sikessem\Capsule\Traits\HasMutator;

abstract class BaseCapsule implements IsAccessible, IsMutable
{
    use HasAccessor, HasMutator;
}
