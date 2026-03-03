<?php

namespace JeffersonGoncalves\Filament\Keyable\Resources\Keyables;

use Filament\Panel;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Schemas\KeyableForm;
use JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Schemas\KeyableInfolist;
use JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Tables\KeyablesTable;
use JeffersonGoncalves\Filament\Keyable\Support\Utils;

class KeyableResource extends Resource
{
    public static function form(Schema $schema): Schema
    {
        return KeyableForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KeyableInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KeyablesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeyables::route('/'),
            'create' => Pages\CreateKeyable::route('/create'),
            'view' => Pages\ViewKeyable::route('/{record}'),
        ];
    }

    public static function getCluster(): ?string
    {
        return Utils::getResourceCluster() ?? static::$cluster;
    }

    public static function getModel(): string
    {
        return Utils::getKeyableModel();
    }

    public static function getModelLabel(): string
    {
        return __('filament-keyable::filament-keyable.resource.label.keyable');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-keyable::filament-keyable.resource.label.keyables');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Utils::isResourceNavigationRegistered();
    }

    public static function getNavigationGroup(): ?string
    {
        if (Utils::isResourceNavigationGroupEnabled()) {
            return __('filament-keyable::filament-keyable.nav.group');
        }

        return '';
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-keyable::filament-keyable.nav.keyable.label');
    }

    public static function getNavigationIcon(): string
    {
        return Utils::getResourceNavigationIcon();
    }

    public static function getNavigationSort(): ?int
    {
        return Utils::getResourceNavigationSort();
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return Utils::getResourceSlug();
    }

    public static function getNavigationBadge(): ?string
    {
        if (Utils::isResourceNavigationBadgeEnabled()) {
            return strval(static::getEloquentQuery()->count());
        }

        return null;
    }
}
