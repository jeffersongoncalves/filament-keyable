<?php

namespace JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use JeffersonGoncalves\Filament\Keyable\Support\Utils;

class KeyableInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns()
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('filament-keyable::filament-keyable.infolist.name')),
                        TextEntry::make('key')
                            ->label(__('filament-keyable::filament-keyable.infolist.key'))
                            ->copyable()
                            ->copyMessage(__('filament-keyable::filament-keyable.infolist.copy_message'))
                            ->copyMessageDuration(1500),
                        TextEntry::make('keyable_id')
                            ->label(fn () => __('filament-keyable::filament-keyable.infolist.keyable_id'))
                            ->hidden(fn () => Utils::isAllowEmptyModels()),
                        TextEntry::make('keyable_type')
                            ->label(fn () => __('filament-keyable::filament-keyable.infolist.keyable_type'))
                            ->hidden(fn () => Utils::isAllowEmptyModels()),
                    ]),
            ]);
    }
}
