<?php

use Emsifa\RandomImage\RandomImage;

it('generate correct url', function (RandomImage $img, $expect) {
    expect($img->url())->toEqual($expect);
})
->with([
    'no argument' => [RandomImage::make(), 'https://source.unsplash.com/random/'],
    'width only' => [RandomImage::make(300), 'https://source.unsplash.com/random/300x300/'],
    'height only' => [RandomImage::make(height: 200), 'https://source.unsplash.com/random/200x200/'],
    'query only' => [RandomImage::make(query: 'city light'), 'https://source.unsplash.com/random/?city%20light'],
    'width and query' => [RandomImage::make(180, query: 'nature'), 'https://source.unsplash.com/random/180x180/?nature'],
    'height and query' => [RandomImage::make(190, query: 'nature'), 'https://source.unsplash.com/random/190x190/?nature'],
    'width, height, and query' => [RandomImage::make(150, 50, query: 'nature'), 'https://source.unsplash.com/random/150x50/?nature'],
]);
