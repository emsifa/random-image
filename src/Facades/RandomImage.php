<?php

namespace Emsifa\RandomImage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Emsifa\RandomImage\RandomImage
 */
class RandomImage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Emsifa\RandomImage\RandomImage::class;
    }
}
