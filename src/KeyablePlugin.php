<?php

namespace JeffersonGoncalves\Filament\Keyable;

use Filament\Contracts\Plugin;
use Filament\Panel;
use JeffersonGoncalves\Filament\Keyable\Support\Utils;

class KeyablePlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-keyable';
    }

    public function register(Panel $panel): void
    {
        if (! Utils::isResourcePublished($panel)) {
            $panel->resources([Resources\KeyableResource::class]);
        }
    }

    public function boot(Panel $panel): void {}
}
