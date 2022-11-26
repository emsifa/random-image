<?php

namespace Emsifa\RandomImage\Concerns;

use Closure;
use Emsifa\RandomImage\ImageResult;
use Intervention\Image\ImageManager;

trait ImageResultManipulator
{
    public function fit(int $width, ?int $height, ?string $position, ?Closure $callback = null): ImageResult
    {
        return $this->applyManipulation('fit', [$width, $height, $callback, $position]);
    }

    public function resize(int $width, int $height = null, ?Closure $callback = null): ImageResult
    {
        return $this->applyManipulation('resize', [$width, $height, $callback]);
    }

    public function crop(int $width, int $height = null, ?int $x = null, ?int $y = null): ImageResult
    {
        return $this->applyManipulation('crop', [$width, $height, $x, $y]);
    }

    public function widen(int $width, ?Closure $callback = null): ImageResult
    {
        return $this->applyManipulation('widen', [$width, $callback]);
    }

    public function heighten(int $height, ?Closure $callback = null): ImageResult
    {
        return $this->applyManipulation('heighten', [$height, $callback]);
    }

    public function greyscale(): ImageResult
    {
        return $this->applyManipulation('greyscale');
    }

    public function blur(?int $amount = null): ImageResult
    {
        return $this->applyManipulation('blur', [$amount]);
    }

    public function toWebp(?int $quality = 90): ImageResult
    {
        return $this->applyManipulation('', [], 'webp', $quality);
    }

    public function toPng(?int $quality = 90): ImageResult
    {
        return $this->applyManipulation('', [], 'png', $quality);
    }

    public function applyManipulation(
        string $method,
        array $args = [],
        ?string $format = null,
        int $quality = 90,
    ): ImageResult {
        $source = $this->fullPath();
        $manager = new ImageManager([
            'driver' => config('random-image.intervention.driver'),
        ]);

        $img = $manager->make($source);
        if ($method) {
            call_user_func_array([$img, $method], $args);
        }

        if ($format) {
            // Save new image with new extension
            $filepath = dirname($this->path()).'/'.pathinfo($this->path(), PATHINFO_FILENAME).'.'.$format;
            $content = $img->encode($format, $quality);
            $this->disk()->put($filepath, $content);

            // Remove previous image
            $this->disk()->delete($this->path());

            return new ImageResult($filepath, $this->disk);
        }

        $img->save();

        return $this;
    }
}
