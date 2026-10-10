<?php

namespace JeffersonGoncalves\Filament\Keyable\Tests\Fixtures;

use Filament\Panel;
use Filament\PanelProvider;
use JeffersonGoncalves\Filament\Keyable\KeyablePlugin;

class TestPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('test')
            ->path('test')
            ->plugin(KeyablePlugin::make());
    }
}
