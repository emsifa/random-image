<?php

namespace Emsifa\RandomImage;

use Illuminate\Support\Str;

class Helper
{
    public static function randomName(): string
    {
        return Str::random(28).'-'.uniqid();
    }
}
