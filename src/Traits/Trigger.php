<?php

namespace Sikessem\Capsule\Traits;

use Sikessem\Capsule\Utils\Backtrace;
use Throwable;

trait Trigger
{
    /**
     * @param  array<string|int>  $arguments
     */
    public static function create(string $message = '', array $arguments = [], int $code = 0, ?Throwable $previous = null): Throwable
    {
        if ($arguments !== []) {
            $message = sprintf($message, ...$arguments);
        }

        $super = new static ($message, $code, $previous);
        $trace = new Backtrace(limit: 3);

        $file = $trace->getFile(0);
        $line = $trace->getLine(0);

        if (str_starts_with($file ?? __FILE__, dirname(__DIR__))) {
            $file = $trace->getFile(1);
            $line = $trace->getLine(1);
        }

        $super->file = $file ?? __FILE__;
        $super->line = $line ?? __LINE__;

        return $super;
    }
}
