<?php

namespace Emsifa\RandomImage;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RandomImageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name('random-image')->hasConfigFile();
    }

    public function boot()
    {
        $provider = app()->make(config('random-image.provider'));
        RandomImage::setProvider($provider);
    }
}
