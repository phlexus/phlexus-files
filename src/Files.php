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
     * @param FilesystemAdapter $fileSystemAdapter
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

        return $name->format();
    }

    /**
     * @param string $filenamePath
     * @return bool
     * @throws FilesystemException
     */
    public function exist(string $filenamePath): bool
    {
        return $this->fileSystemAdapter->fileExists($filenamePath);
    }

    /**
     * @param string $filenamePath
     * @throws FilesystemException
     */
    public function delete(string $filenamePath)
    {
        $this->fileSystemAdapter->delete($filenamePath);
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
     * @param string $contents
     * @param FormatterInterface|null $formatter
     * @throws FilesystemException
     */
    public function uploadFormatted(string $filenamePath, string $contents, ?FormatterInterface $formatter = null): void
    {
        $this->upload($this->makeFormattedPath($filenamePath, $formatter), $contents);
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

    /**
     * @param string $filenamePath
     * @param $resource
     * @param FormatterInterface|null $formatter
     * @throws FilesystemException
     */
    public function uploadStreamFormatted(string $filenamePath, $resource, ?FormatterInterface $formatter = null): void
    {
        $this->uploadStream($this->makeFormattedPath($filenamePath, $formatter), $resource);
    }

    /**
     * @param string $filenamePath
     * @param FormatterInterface|null $formatter
     * @return string
     */
    private function makeFormattedPath(string $filenamePath, ?FormatterInterface $formatter = null): string
    {
        $pathParts = explode(DIRECTORY_SEPARATOR, $filenamePath);
        $pathOnly = array_pop($pathParts);

        $filename = end($pathParts);
        $filename = $this->setFormattedName($filename, $formatter);

        return $pathOnly . DIRECTORY_SEPARATOR . $filename;
    }
}
