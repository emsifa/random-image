<?php

namespace Emsifa\RandomImage;

use Illuminate\Support\Arr;

class History
{
    protected static array $histories = [];

    public static function all()
    {
        return static::$histories;
    }

    public static function push(ImageResult $image)
    {
        array_push(static::$histories, $image);
    }

    public static function last(): ImageResult|null
    {
        return Arr::last(static::$histories);
    }

    public static function clear()
    {
        static::$histories = [];
    }
}
