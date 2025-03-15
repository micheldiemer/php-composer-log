<?php

namespace Md\Log;

use Md\Log\LevelLogger;

class RawLogger extends LevelLogger
{
    protected static string $format = "%10s %s";

    protected function output($level, string|\Stringable $message, array $context = [], string|\Stringable $interpolated = '')
    {
        echo sprintf(self::$format, $level, $interpolated) . PHP_EOL;
    }
}
