<?php

namespace Md\Log;

use Stringable;

class HtmlLogger extends LevelLogger
{
    protected string $htmlTag = "span";

    public function cssStyles($emergency, $alert, $critical, $error, $warning, $notice, $info, $debug): string
    {
        return <<<CSS
            .log-emergency {
                $emergency;
            }
            .log-alert {
                $alert;
            }
            .log-critical {
                $critical;
            }
            .log-error {
                $error;
            }
            .log-warning {
                $warning;
            }
            .log-notice {
                $notice;
            }
            .log-info {
                $info;
            }
            .log-debug {
                $debug;
            }
            CSS;
    }

    public function cssClassNames(): string
    {
        return implode(PHP_EOL, array_map(
            function ($level) {
                return ".log-{$level}  {\n \n}\n}";
            },
            array_values($this->levelsToLog)
        ));
    }

    public function setHtmlTag($tag): HtmlLogger
    {
        $this->htmlTag = $tag;
        return $this;
    }

    public function getHtmlTag(): string
    {
        return $this->htmlTag;
    }

    protected function output($level, string|\Stringable $message, array $context = [], string|\Stringable $interpolated = '')
    {
        echo "<{$this->htmlTag} class=\"log-{$level}\">" . htmlspecialchars($interpolated) . "</{$this->htmlTag}>";
    }
}
