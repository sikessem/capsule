<?php

namespace Sikessem\Capsule\Exceptions;

final class GetterException extends BaseException
{
    public static function create(string $property): static
    {
        return new self(sprintf('Unable to get property %s.', $property));
    }
}
