<?php

namespace Emsifa\RandomImage;

use Emsifa\RandomImage\Commands\RandomImageCommand;
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
        $package
            ->name('random-image')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_random-image_table')
            ->hasCommand(RandomImageCommand::class);
    }
}
