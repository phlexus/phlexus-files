<?php

declare(strict_types=1);

namespace Phlexus\Files\Formatter;

class Md5Formatter implements FormatterInterface
{
    public function format(string $name): string
    {
        return md5($name);
    }
}
