<?php

namespace Emsifa\RandomImage\Providers;

use Emsifa\RandomImage\Provider;

class LoremPicsumProvider extends Provider
{
    public function generateUrl(?int $width = null, ?int $height = null, ?string $query = null): string
    {
        $size = $this->getSizePath($width, $height);

        return "https://picsum.photos/{$size}";
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
