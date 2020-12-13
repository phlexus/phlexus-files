<?php

declare(strict_types=1);

namespace Phlexus\Files;

use League\Flysystem\Config;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\FilesystemException;
use Phlexus\Files\File\Name;
use Phlexus\Files\Formatter\FormatterInterface;

class Files
{
    protected $fileSystemAdapter;

    /**
     * Files constructor
     *
     * @param FilesystemAdapter $adapter
     */
    public function __construct(FilesystemAdapter $fileSystemAdapter)
    {
        $this->fileSystemAdapter = $fileSystemAdapter;
    }

    /**
     * @param string $filename
     * @param FormatterInterface|null $formatter
     * @return string
     */
    public function setFormattedName(string $filename, ?FormatterInterface $formatter = null): string
    {
        $name = new Name($filename);
        if ($formatter !== null) {
            $name->setFormatter($formatter);
        }

        return $name->getFormattedName();
    }

    /**
     * @param string $filenamePath
     * @param string $contents
     * @throws FilesystemException
     */
    public function upload(string $filenamePath, string $contents): void
    {
        $this->fileSystemAdapter->write($filenamePath, $contents, new Config());
    }

    /**
     * @param string $filenamePath
     * @param $resource
     * @throws FilesystemException
     */
    public function uploadStream(string $filenamePath, $resource): void
    {
        $this->fileSystemAdapter->writeStream($filenamePath, $resource, new Config());
    }
}
