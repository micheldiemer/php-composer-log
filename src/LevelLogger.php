<?php

namespace Md\Log;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

abstract class LevelLogger extends AbstractLogger
{
    protected const LEVELS_ALL = [LogLevel::EMERGENCY, LogLevel::ALERT, LogLevel::CRITICAL, LogLevel::ERROR, LogLevel::WARNING, LogLevel::NOTICE, LogLevel::INFO, LogLevel::DEBUG];

    protected $levelsToLog = self::LEVELS_ALL;
    protected $doLog;
    protected $interpolated;

    protected function interpolate($message, array $context = [])
    {
        // build a replacement array with braces around the context keys
        $replace = [];
        foreach ($context as $key => $val) {
            // check that the value can be cast to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            } else {
                $replace['{' . $key . '}'] = var_export($val, true);
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }

    // 0=higher, 7=lower
    protected function setLevel(int $level)
    {
        $this->levelsToLog[] = [];
        for ($i = 0; $i <= $level && $i < count(self::LEVELS_ALL); $i++) {
            $this->levelsToLog[] = self::LEVELS_ALL[$i];
        }
    }

    abstract protected function output($level, string|\Stringable $message, array $context = [], string|\Stringable $interpolated = '');

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $this->doLog = in_array($level, $this->levelsToLog);
        if ($this->doLog) {
            $this->output($level, $message, $context, $this->interpolate($message, $context));
        }
    }
}
