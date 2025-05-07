<?php

namespace JeffersonGoncalves\Filament\Keyable;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class KeyableServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-keyable')
            ->hasConfigFile()
            ->hasTranslations();
    }
}
