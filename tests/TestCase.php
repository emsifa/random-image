<?php

namespace Emsifa\RandomImage\Tests;

use Emsifa\RandomImage\RandomImageServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            RandomImageServiceProvider::class,
        ];
    }
}
