<?php

use Illuminate\Support\Facades\Storage;

afterAll(function () {
    clear_test_files();
});

it('get correct url', function () {
    $image = create_test_image_result();
    $path = $image->path();

    expect($image->url())->toEqual("http://random-image.test/storage/{$path}");
});

it('get correct full path', function () {
    $image = create_test_image_result();
    $path = $image->path();
    /**
     * @var Illuminate\Filesystem\FilesystemAdapter\FilesystemAdapter
     */
    $disk = Storage::disk('test');

    expect($image->fullPath())->toEqual($disk->path($path));
});

it('copy image to another file', function () {
    $disk = Storage::disk("test");
    $original = create_test_image_result();
    $copy = $original->copy();

    expect($disk->exists($original))->toBeTrue();
    expect($disk->exists($copy))->toBeTrue();
    expect($disk->get($original))->not->toBeEmpty();
    expect($disk->get($copy))->not->toBeEmpty();

    expect($disk->get($original))->toEqual($disk->get($copy));
});
