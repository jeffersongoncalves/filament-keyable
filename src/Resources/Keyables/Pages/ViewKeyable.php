<?php

namespace JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Pages;

use Filament\Resources\Pages\ViewRecord;
use JeffersonGoncalves\Filament\Keyable\Resources\Keyables\KeyableResource;

class ViewKeyable extends ViewRecord
{
    protected static string $resource = KeyableResource::class;
}
