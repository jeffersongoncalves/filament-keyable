<?php

namespace JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\Filament\Keyable\Resources\Keyables\KeyableResource;

class ListKeyables extends ListRecords
{
    protected static string $resource = KeyableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
