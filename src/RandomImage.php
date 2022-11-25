<?php

namespace Emsifa\RandomImage;

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

    public function store(string $directory = '', ?string $disk = null)
    {
        // unimplemented
    }

    public function storeAs(string $filepath, ?string $disk = null)
    {
        // unimplemented
    }

    protected function download()
    {
        // unimplemented
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
