<?php

declare(strict_types=1);

namespace Phlexus\Files\Formatter;

class TimeFormatter implements FormatterInterface
{
    public function format(string $name): string
    {
        return (string)time();
    }
}
