<?php

use Emsifa\RandomImage\Providers\UnsplashProvider;

it('generate correct url', function ($args, $expect) {
    $provider = new UnsplashProvider();
    expect(call_user_func_array([$provider, 'generateUrl'], $args))->toEqual($expect);
})
->with([
    'no argument' => [[null, null, null], 'https://source.unsplash.com/random/'],
    'width only' => [[300, null, null], 'https://source.unsplash.com/random/300x300/'],
    'height only' => [[null, 200, null], 'https://source.unsplash.com/random/200x200/'],
    'query only' => [[null, null, 'city light'], 'https://source.unsplash.com/random/?city%20light'],
    'width and query' => [[180, null, 'nature'], 'https://source.unsplash.com/random/180x180/?nature'],
    'height and query' => [[null, 190, 'nature'], 'https://source.unsplash.com/random/190x190/?nature'],
    'width, height, and query' => [[150, 50, 'nature'], 'https://source.unsplash.com/random/150x50/?nature'],
]);
