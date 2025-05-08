<?php

namespace JeffersonGoncalves\Filament\Keyable\Support;

use Filament\Panel;
use Givebutter\LaravelKeyable\Models\ApiKey;

use function config;

class Utils
{
    public static function isResourcePublished(Panel $panel): bool
    {
        return str(string: collect(value: $panel->getResources())->values()->join(','))->contains('KeyableResource');
    }

    public static function getResourceCluster(): ?string
    {
        return config('filament-keyable.keyable_resource.cluster', null);
    }

    public static function isAllowEmptyModels(): bool
    {
        return config('keyable.allow_empty_models', false);
    }

    public static function getModels(): array
    {
        return config('filament-keyable.models', []);
    }

    public static function getKeyableModel(): string
    {
        return config('filament-keyable.keyable_resource.model', ApiKey::class);
    }

    public static function isResourceNavigationRegistered(): bool
    {
        return config('filament-keyable.keyable_resource.should_register_navigation', true);
    }

    public static function isResourceNavigationGroupEnabled(): bool
    {
        return config('filament-keyable.keyable_resource.navigation_group', true);
    }

    public static function getResourceNavigationSort(): ?int
    {
        return config('filament-keyable.keyable_resource.navigation_sort');
    }

    public static function getResourceSlug(): string
    {
        return (string)config('filament-keyable.keyable_resource.slug');
    }

    public static function isResourceNavigationBadgeEnabled(): bool
    {
        return config('filament-keyable.keyable_resource.navigation_badge', true);
    }
}
