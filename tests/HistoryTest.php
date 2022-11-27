<?php

use Emsifa\RandomImage\History;

beforeEach(function () {
    History::clear();
});

it('push image to histories', function () {
    expect(History::all())->toBe([]);

    $image = create_test_image_result();
    History::push($image);

    expect(History::all())->toBe([$image]);
});

it('get last item in history', function () {
    $image = create_test_image_result();
    History::push($image);
    expect(History::last())->toBe($image);
});
