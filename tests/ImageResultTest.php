<?php

use Emsifa\RandomImage\ImageResult;

afterAll(function () {
    clear_test_files();
});

it('apply resize', function () {
    $image = create_test_image_result();
    expect($image->resize(100, 100))->toBeInstanceOf(ImageResult::class);
});

it('apply fit', function () {
    $image = create_test_image_result();
    expect($image->fit(200, 100))->toBeInstanceOf(ImageResult::class);
});

it('apply crop', function () {
    $image = create_test_image_result();
    expect($image->crop(200, 100))->toBeInstanceOf(ImageResult::class);
});

it('apply widen', function () {
    $image = create_test_image_result();
    expect($image->widen(200))->toBeInstanceOf(ImageResult::class);
});

it('apply heighten', function () {
    $image = create_test_image_result();
    expect($image->heighten(200))->toBeInstanceOf(ImageResult::class);
});

it('apply greyscale', function () {
    $image = create_test_image_result();
    expect($image->greyscale())->toBeInstanceOf(ImageResult::class);
});

it('apply blur', function () {
    $image = create_test_image_result();

    // We resize it first to minimize the memory consumption
    expect($image->resize(50, 50)->blur())->toBeInstanceOf(ImageResult::class);
});

it('apply toPng', function () {
    $image = create_test_image_result();
    expect($image->toPng())->toBeInstanceOf(ImageResult::class);
});

it('apply toWebp', function () {
    $image = create_test_image_result();
    expect($image->toWebp())->toBeInstanceOf(ImageResult::class);
});
