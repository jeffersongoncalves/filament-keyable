<?php

namespace JeffersonGoncalves\Filament\Keyable\Resources\KeyableResource\Pages;

use Filament\Resources\Pages\ListRecords;
use JeffersonGoncalves\Filament\Keyable\Resources\KeyableResource;

class ListKeyables extends ListRecords
{
    protected static string $resource = KeyableResource::class;
}
