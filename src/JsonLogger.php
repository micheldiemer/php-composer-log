<?php

namespace Md\Log;

class JsonLogger extends LevelLogger
{
    protected function output($level, string|\Stringable $message, array $context = [], string|\Stringable $interpolated = '')
    {
        echo json_encode([
            'level' => $level,
            'message' => $interpolated,
            'context' => $context,
        ]) . PHP_EOL;
    }
}
