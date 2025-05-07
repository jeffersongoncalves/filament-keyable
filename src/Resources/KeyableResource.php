<?php

namespace JeffersonGoncalves\Filament\Keyable\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\Keyable\Resources\KeyableResource\Pages;
use JeffersonGoncalves\Filament\Keyable\Support\Utils;

class KeyableResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns()
                    ->schema([
                        Forms\Components\MorphToSelect::make('keyable')
                            ->required(fn() => !Utils::isAllowEmptyModels())
                            ->hidden(fn() => Utils::isAllowEmptyModels())
                            ->types(self::getModels()),
                    ]),
            ]);
    }

    private static function getModels(): array
    {
        $models = Utils::getModels();
        if (empty($models)) {
            return [];
        }
        foreach ($models as $model) {
            $models[] = Forms\Components\MorphToSelect\Type::make($model);
        }
        return $models;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->columns()
                    ->schema([
                        Infolists\Components\TextEntry::make('keyable_id')
                            ->label(fn() => __('filament-keyable::filament-keyable.column.keyable_id'))
                            ->hidden(fn() => Utils::isAllowEmptyModels()),
                        Infolists\Components\TextEntry::make('keyable_type')
                            ->label(fn() => __('filament-keyable::filament-keyable.column.keyable_type'))
                            ->hidden(fn() => Utils::isAllowEmptyModels()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(fn() => __('filament-keyable::filament-keyable.column.name')),
                Tables\Columns\TextColumn::make('processed_at')
                    ->label(fn() => __('filament-keyable::filament-keyable.column.processed_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
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
        return __('filament-keyable::filament-keyable.nav.keyable.icon');
    }

    public static function getNavigationSort(): ?int
    {
        return Utils::getResourceNavigationSort();
    }

    public static function getSlug(): string
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
