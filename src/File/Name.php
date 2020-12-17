<?php

declare(strict_types=1);

namespace Phlexus\Files\File;

use Phlexus\Files\Formatter\FormatterInterface;
use Phlexus\Files\Formatter\OriginalFormatter;

class Name
{
    /**
     * File name
     *
     * @var string
     */
    protected $name;

    /**
     * @var OriginalFormatter
     */
    protected $formatter;

    /**
     * Name constructor
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->formatter = new OriginalFormatter();
    }

    /**
     * @param FormatterInterface $formatter
     * @return $this
     */
    public function setFormatter(FormatterInterface $formatter): self
    {
        $this->formatter = $formatter;

        return $this;
    }

    /**
     * @return FormatterInterface
     */
    public function getFormatter(): FormatterInterface
    {
        return $this->formatter;
    }

    /**
     * @return string
     */
    public function format(): string
    {
        $filename = $this->getFilenameOnly();
        $extension = $this->getFilenameExtension();

        $formatted = $this->getFormatter()->format($filename);

        if ($extension === null) {
            return $formatted;
        }

        return implode('.', [$formatted, $extension]);
    }

    /**
     * Get file name without extension
     *
     * @return string
     */
    public function getFilenameOnly(): string
    {
        $parts = explode('.', $this->name);

        return current($parts);
    }

    /**
     * Returns extension name based on filename
     *
     * In case filename has no extension, `null` will be returned.
     *
     * @return string|null
     */
    public function getFilenameExtension(): ?string
    {
        $parts = explode('.', $this->name);

        /**
         * Filename without extension
         */
        if (count($parts) < 2) {
            return null;
        }

        return (string)end($parts);
    }
}
