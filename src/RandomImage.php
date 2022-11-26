<?php

namespace Emsifa\RandomImage;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RandomImage
{
    public function __construct(
        protected ?int $width = null,
        protected ?int $height = null,
        protected ?string $query = null,
    ) {
    }

    public function url()
    {
        $size = $this->getSizePath();
        $query = $this->query ? '?'.rawurlencode($this->query) : '';

        return $size
            ? "https://source.unsplash.com/random/{$size}/{$query}"
            : "https://source.unsplash.com/random/{$query}";
    }

    public function store(string $directory = '', ?string $disk = null): ImageResult
    {
        $filename = Helper::randomName().'.jpeg';
        $filepath = rtrim($directory, '/').'/'.$filename;

        return $this->storeAs($filepath, $disk);
    }

    public function storeAs(string $filepath, ?string $disk = null): ImageResult
    {
        $content = $this->download();
        Storage::disk($disk)->put($filepath, $content);

        return new ImageResult($filepath, $disk);
    }

    protected function download(): string
    {
        return Http::throw()
            ->withHeaders(config('random-image.headers', []))
            ->timeout(config('random-image.timeout', 10))
            ->retry(
                config('random-image.retry.limit', 3),
                config('random-image.retry.sleep', 500),
            )
            ->get($this->url())
            ->body();
    }

    protected function getSizePath(): string|null
    {
        if ($this->width && $this->height) {
            return "{$this->width}x{$this->height}";
        } elseif ($this->width || $this->height) {
            $size = $this->width ?: $this->height;

            return "{$size}x{$size}";
        } else {
            return null;
        }
    }

    public static function make(
        ?int $width = null,
        ?int $height = null,
        ?string $query = null,
    ): self {
        return new self(
            width: $width,
            height: $height,
            query: $query,
        );
    }
}
