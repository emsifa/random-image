<?php

use Emsifa\RandomImage\History;
use Emsifa\RandomImage\RandomImage;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    History::clear();
});

it('store image to disk', function ($params) {
    $result = (RandomImage::make($params[0], $params[1]))->store('test-store', 'custom');

    expect(Storage::disk('custom')->exists($result))->toBeTrue();
    expect(Storage::disk('custom')->get($result))->not->toBeEmpty();
})
->with([
    'no argument' => [[null, null]],
    'with width' => [[100, null]],
    'with height' => [[null, 100]],
    'with width and height' => [[100, 50]],
]);

it('get previous image', function () {
    expect(RandomImage::previous())->toBeNull();
    $image = RandomImage::make()->store('test-previous', 'custom');
    expect(RandomImage::previous())->toBe($image);
});
