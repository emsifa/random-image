<?php

use Emsifa\RandomImage\RandomImage;
use Illuminate\Support\Facades\Storage;

it('store image to disk', function (RandomImage $generator) {
    $result = $generator->store('test-store', 'custom');

    expect(Storage::disk('custom')->exists($result))->toBeTrue();
    expect(Storage::disk('custom')->get($result))->not->toBeEmpty();
})
->with([
    'no argument' => RandomImage::make(),
    'with width' => RandomImage::make(width: 100),
    'with height' => RandomImage::make(height: 100),
    'with width and height' => RandomImage::make(100, 50),
]);
