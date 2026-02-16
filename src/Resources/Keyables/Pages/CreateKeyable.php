<?php

namespace JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\Filament\Keyable\Resources\Keyables\KeyableResource;

class CreateKeyable extends CreateRecord
{
    protected static string $resource = KeyableResource::class;
}
