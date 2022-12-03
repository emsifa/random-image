<?php

namespace Emsifa\RandomImage;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RandomImage
{
    public function __construct(
        protected Provider $provider,
        protected ?int $width = null,
        protected ?int $height = null,
        protected ?string $query = null,
    ) {
    }

    public function withProvider(Provider $provider): static
    {
        $this->provider = $provider;

        return $this;
    }

    public function url()
    {
        return $this->provider->generateUrl($this->width, $this->height, $this->query);
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
        ?Provider $provider = null,
    ): self {
        return new self(
            provider: $provider ?? app()->make(Provider::class),
            width: $width,
            height: $height,
            query: $query,
        );
    }

    public static function previous(): ImageResult|null
    {
        return History::last();
    }
}
