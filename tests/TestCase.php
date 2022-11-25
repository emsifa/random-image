<?php

namespace Emsifa\RandomImage\Tests;

use Emsifa\RandomImage\RandomImageServiceProvider;
use Illuminate\Support\Facades\Storage;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::set('custom', Storage::createLocalDriver([
            'driver' => 'local',
            'root' => realpath(__DIR__ . '/../storage'),
        ]));
    }

    protected function getPackageProviders($app)
    {
        return [
            RandomImageServiceProvider::class,
        ];
    }
}
