<?php

namespace Emsifa\RandomImage;

use Emsifa\RandomImage\Exceptions\CopyFailedException;
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

    public function copy(?string $disk = null): ImageResult
    {
        $filename = Helper::randomName();
        $dir = dirname($this->path);

        return $this->copyAs("{$dir}/{$filename}", $disk);
    }

    public function copyAs(string $filepath, ?string $disk = null): ImageResult
    {
        $disk = $disk ?? $this->disk;
        $succeed = $this->disk === $disk
            ? Storage::disk($disk)->copy($this->path, $filepath)
            : Storage::disk($disk)->put($filepath, $this->getContent());

        throw_unless($succeed, new CopyFailedException('Copy image failed'));

        return new ImageResult($filepath, $disk);
    }

    public function getContent()
    {
        return Storage::disk($this->disk)->get($this->path);
    }

    public function __toString()
    {
        return $this->path();
    }
}
