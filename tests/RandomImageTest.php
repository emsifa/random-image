<?php

use Emsifa\RandomImage\History;
use Emsifa\RandomImage\RandomImage;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    History::clear();
});

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

it('get previous image', function () {
    expect(RandomImage::previous())->toBeNull();
    $image = RandomImage::make()->store('test-previous', 'custom');
    expect(RandomImage::previous())->toBe($image);
});
