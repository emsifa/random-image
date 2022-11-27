<?php

namespace Emsifa\RandomImage\Providers;

use Emsifa\RandomImage\Provider;

class UnsplashProvider extends Provider
{
    public function generateUrl(?int $width = null, ?int $height = null, ?string $query = null): string
    {
        $size = $this->getSizePath($width, $height);
        $query = $query ? '?'.rawurlencode($query) : '';

        return $size
            ? "https://source.unsplash.com/random/{$size}/{$query}"
            : "https://source.unsplash.com/random/{$query}";
    }

    protected function getSizePath(?int $width, ?int $height): string|null
    {
        if ($width && $height) {
            return "{$width}x{$height}";
        } elseif ($width || $height) {
            $size = $width ?: $height;

            return "{$size}x{$size}";
        } else {
            return null;
        }
    }
}
