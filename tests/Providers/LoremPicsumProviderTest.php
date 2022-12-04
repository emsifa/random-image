<?php

use Emsifa\RandomImage\Providers\LoremPicsumProvider;

it('generate correct url', function ($args, $expect) {
    $provider = new LoremPicsumProvider();
    expect(call_user_func_array([$provider, 'generateUrl'], $args))->toEqual($expect);
})
->with([
    'no argument' => [[null, null, null], 'https://picsum.photos/600/400'],
    'width only' => [[300, null, null], 'https://picsum.photos/300/300'],
    'height only' => [[null, 200, null], 'https://picsum.photos/200/200'],
    'query only' => [[null, null, 'city light'], 'https://picsum.photos/600/400'],
    'width and query' => [[180, null, 'nature'], 'https://picsum.photos/180/180'],
    'height and query' => [[null, 190, 'nature'], 'https://picsum.photos/190/190'],
    'width, height, and query' => [[150, 50, 'nature'], 'https://picsum.photos/150/50'],
]);
