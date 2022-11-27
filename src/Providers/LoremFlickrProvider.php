<?php

namespace Emsifa\RandomImage\Providers;

use Emsifa\RandomImage\Provider;

class LoremFlickrProvider extends Provider
{
    public function generateUrl(?int $width = null, ?int $height = null, ?string $query = null): string
    {
        $size = $this->getSizePath($width, $height);
        $query = $query ? rawurlencode($query) : '';

        return "https://loremflickr.com/{$size}/{$query}";
    }

    protected function getSizePath(?int $width, ?int $height): string
    {
        if ($width && $height) {
            return "{$width}/{$height}";
        } elseif ($width || $height) {
            $size = $width ?: $height;

            return "{$size}/{$size}";
        } else {
            return '600/400';
        }
    }
}
