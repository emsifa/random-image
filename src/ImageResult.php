<?php

namespace Emsifa\RandomImage;

use Emsifa\RandomImage\Concerns\ImageResultManipulator;
use Emsifa\RandomImage\Exceptions\CopyFailedException;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class ImageResult
{
    use ImageResultManipulator;

    public function __construct(
        protected string $path,
        protected ?string $disk = null,
    ) {
    }

    public function path(): string
    {
        return $this->path;
    }

    public function fullPath(): string
    {
        return $this->disk()->path($this->path());
    }

    public function name(): string
    {
        return pathinfo($this->path(), PATHINFO_BASENAME);
    }

    public function url(): string
    {
        return $this->disk()->url($this->path());
    }

    public function disk(): FilesystemAdapter
    {
        return Storage::disk($this->disk);
    }

    public function extension()
    {
        return pathinfo($this->path(), PATHINFO_EXTENSION);
    }

    public function copy(?string $disk = null): ImageResult
    {
        $filename = Helper::randomName().'.'.$this->extension();
        $dir = dirname($this->path);

        return $this->copyAs($dir, $filename, $disk);
    }

    public function copyAs(string $path, string $filename, ?string $disk = null): ImageResult
    {
        $filepath = rtrim($path, '/').'/'.ltrim($filename, '/');
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
