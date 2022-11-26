<?php

use Emsifa\RandomImage\Helper;
use Emsifa\RandomImage\ImageResult;
use Emsifa\RandomImage\Tests\TestCase;
use Illuminate\Support\Facades\Storage;

uses(TestCase::class)->in(__DIR__);

/**
 * Copy test image so we can use it multiple times
 */
function create_test_file() {
    $disk = "test";
    $original = "sample-image.jpg";
    $copy = Helper::randomName().".jpg";

    Storage::disk($disk)->copy($original, $copy);

    return [$copy, $disk];
}

function create_test_image_result(): ImageResult {
    [$file, $disk] = create_test_file();
    return new ImageResult($file, $disk);
}

function clear_test_files() {
    $disk = Storage::disk("test");
    $files = $disk->files(null, true);
    $keeps = ["sample-image.jpg"];

    foreach ($files as $file) {
        if (!in_array($file, $keeps)) {
            $disk->delete($file);
        }
    }
}
