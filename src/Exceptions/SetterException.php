<?php

namespace Sikessem\Capsule\Exceptions;

final class SetterException extends BaseException
{
    public static function create(string $property): static
    {
        return new self(sprintf('Unable to set property %s.', $property));
    }
}
