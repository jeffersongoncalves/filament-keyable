<?php

use JeffersonGoncalves\Filament\Keyable\KeyablePlugin;
use JeffersonGoncalves\Filament\Keyable\Resources\KeyableResource;

it('loads every class it ships', function (string $class) {
    expect(class_exists($class) || interface_exists($class) || trait_exists($class))->toBeTrue();
})->with([
    'JeffersonGoncalves\\Filament\\Keyable\\KeyablePlugin',
    'JeffersonGoncalves\\Filament\\Keyable\\KeyableServiceProvider',
    'JeffersonGoncalves\\Filament\\Keyable\\Resources\\KeyableResource\\Pages\\CreateKeyable',
    'JeffersonGoncalves\\Filament\\Keyable\\Resources\\KeyableResource\\Pages\\ListKeyables',
    'JeffersonGoncalves\\Filament\\Keyable\\Resources\\KeyableResource\\Pages\\ViewKeyable',
    'JeffersonGoncalves\\Filament\\Keyable\\Resources\\KeyableResource',
    'JeffersonGoncalves\\Filament\\Keyable\\Support\\Utils',
]);

it('registers on a panel', function () {
    $panel = Filament\Facades\Filament::getPanel('test');

    expect($panel->hasPlugin(KeyablePlugin::make()->getId()))->toBeTrue()
        ->and($panel->getResources())->toContain(KeyableResource::class);
});
