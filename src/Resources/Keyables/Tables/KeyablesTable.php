<?php

namespace JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\Keyable\Support\Utils;

class KeyablesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(fn () => __('filament-keyable::filament-keyable.column.name')),
                TextColumn::make('keyable_id')
                    ->label(fn () => __('filament-keyable::filament-keyable.column.keyable_id'))
                    ->hidden(fn () => Utils::isAllowEmptyModels()),
                TextColumn::make('keyable_type')
                    ->label(fn () => __('filament-keyable::filament-keyable.column.keyable_type'))
                    ->hidden(fn () => Utils::isAllowEmptyModels()),
                TextColumn::make('last_used_at')
                    ->label(fn () => __('filament-keyable::filament-keyable.column.last_used_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
