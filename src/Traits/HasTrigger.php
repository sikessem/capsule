<?php

namespace Sikessem\Capsule\Traits;

use Throwable;

trait HasTrigger
{
    /**
     * @param  array<string|int>  $arguments
     */
    public static function create(string $message = '', array $arguments = [], int $code = 0, ?Throwable $previous = null): Throwable
    {
        if ($arguments !== []) {
            $message = sprintf($message, ...$arguments);
        }

        $super = new static($message, $code, $previous);

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];

        if (str_starts_with($trace['file'] ?? __FILE__, dirname(__DIR__))) {
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2];
        }

        $super->file = $trace['file'] ??= __FILE__;
        $super->line = $trace['line'] ??= __LINE__;

        return $super;
    }
}
