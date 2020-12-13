<?php

declare(strict_types=1);

namespace Phlexus\Files\Formatter;

class OriginalFormatter implements FormatterInterface
{
    public function format(string $name): string
    {
        return $name;
    }
}
