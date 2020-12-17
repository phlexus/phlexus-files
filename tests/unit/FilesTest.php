<?php

declare(strict_types=1);

namespace Phlexus\Files\Tests\Unit;

use Codeception\Test\Unit;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Phlexus\Files\Files;
use Phlexus\Files\Formatter\Md5Formatter;

final class FilesTest extends Unit
{
    public function testSetFormattedNameMd5(): void
    {
        $files = new Files(new LocalFilesystemAdapter(codecept_output_dir()));
        $formatted = $files->setFormattedName('filename.jpg', new Md5Formatter());

        $this->assertSame('435ed7e9f07f740abf511a62c00eef6e.jpg', $formatted);
    }
}
