<?php

namespace Emsifa\RandomImage;

abstract class Provider
{
    abstract public function generateUrl(
        ?int $width = null,
        ?int $height = null,
        ?string $query = null,
    ): string;
}
