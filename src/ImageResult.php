<?php

namespace Emsifa\RandomImage;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class ImageResult
{
    public function __construct(
        protected string $path,
        protected ?string $disk = null,
    ) {
    }

    public function path(): string
    {
        return $this->path;
    }

    public function url(): string
    {
        return $this->disk()->url($this->path());
    }

    public function disk(): FilesystemAdapter
    {
        return Storage::disk($this->disk);
    }

    public function __toString()
    {
        return $this->path();
    }
}
