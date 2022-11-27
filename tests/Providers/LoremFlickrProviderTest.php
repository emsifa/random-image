<?php

use Emsifa\RandomImage\Providers\LoremFlickrProvider;

it('generate correct url', function ($args, $expect) {
    $provider = new LoremFlickrProvider();
    expect(call_user_func_array([$provider, 'generateUrl'], $args))->toEqual($expect);
})
->with([
    'no argument' => [[null, null, null], 'https://loremflickr.com/600/400/'],
    'width only' => [[300, null, null], 'https://loremflickr.com/300/300/'],
    'height only' => [[null, 200, null], 'https://loremflickr.com/200/200/'],
    'query only' => [[null, null, 'city light'], 'https://loremflickr.com/600/400/city%20light'],
    'width and query' => [[180, null, 'nature'], 'https://loremflickr.com/180/180/nature'],
    'height and query' => [[null, 190, 'nature'], 'https://loremflickr.com/190/190/nature'],
    'width, height, and query' => [[150, 50, 'nature'], 'https://loremflickr.com/150/50/nature'],
]);
