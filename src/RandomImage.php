<?php

namespace Emsifa\RandomImage;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RandomImage
{
    protected static $provider;

    public function __construct(
        protected ?int $width = null,
        protected ?int $height = null,
        protected ?string $query = null,
    ) {
    }

    public function url()
    {
        return $this->provider()->generateUrl($this->width, $this->height, $this->query);
    }

    public function provider(): Provider
    {
        return static::$provider;
    }

    public function store(string $directory = '', ?string $disk = null): ImageResult
    {
        $filename = Helper::randomName().'.jpg';
        $filepath = rtrim($directory, '/').'/'.$filename;

        return $this->storeAs($filepath, $disk);
    }

    public function storeAs(string $filepath, ?string $disk = null): ImageResult
    {
        $content = $this->download();
        Storage::disk($disk)->put($filepath, $content);

        $image = new ImageResult($filepath, $disk);

        History::push($image);

        return $image;
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

    public static function setProvider(Provider $provider)
    {
        static::$provider = $provider;
    }

    public static function getProvider(): Provider|null
    {
        return static::$provider;
    }

    public static function previous(): ImageResult|null
    {
        return History::last();
    }
}
