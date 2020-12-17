<?php

declare(strict_types=1);

namespace Phlexus\Files\Tests\Unit\File;

use Codeception\Test\Unit;
use Phlexus\Files\File\Name;
use Phlexus\Files\Formatter\Md5Formatter;
use Phlexus\Files\Formatter\OriginalFormatter;
use Phlexus\Files\Formatter\TimeFormatter;

final class NameTest extends Unit
{
    public function testFormatDefault(): void
    {
        $name = new Name('filename.jpg');

        $this->assertSame('filename.jpg', $name->format());
    }

    public function testSetFormatterMd5(): void
    {
        $name = new Name('filename.jpg');
        $name->setFormatter(new Md5Formatter());

        $this->assertSame('435ed7e9f07f740abf511a62c00eef6e.jpg', $name->format());
    }

    public function testFormatOriginal(): void
    {
        $name = new Name('filename.jpg');
        $name->setFormatter(new OriginalFormatter());

        $this->assertSame('filename.jpg', $name->format());
    }

    public function testFormatTime(): void
    {
        $name = new Name('filename.jpg');
        $name->setFormatter(new TimeFormatter());

        $this->assertSame((string)time() . '.jpg', $name->format());
    }
}
