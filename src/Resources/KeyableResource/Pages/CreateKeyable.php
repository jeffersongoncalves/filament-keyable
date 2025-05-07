<?php

namespace JeffersonGoncalves\Filament\Keyable\Resources\KeyableResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\Filament\Keyable\Resources\KeyableResource;

class CreateKeyable extends CreateRecord
{
    protected static string $resource = KeyableResource::class;
}
