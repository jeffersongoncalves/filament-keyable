<?php

namespace JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Schemas;

use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use JeffersonGoncalves\Filament\Keyable\Support\Utils;

class KeyableForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('filament-keyable::filament-keyable.column.name'))
                            ->required()
                            ->maxLength(255),
                        MorphToSelect::make('keyable')
                            ->label(__('filament-keyable::filament-keyable.column.keyable'))
                            ->required(fn () => ! Utils::isAllowEmptyModels())
                            ->hidden(fn () => Utils::isAllowEmptyModels())
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
            $models[] = Type::make($model);
        }

        return $models;
    }
}
