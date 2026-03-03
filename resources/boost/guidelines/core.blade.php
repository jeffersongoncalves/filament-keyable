## Filament Keyable

Filament plugin that provides API Key management functionality for any model in your application. Built on top of `givebutter/laravel-keyable`, it provides a Filament resource for creating, viewing, and listing API keys with support for polymorphic model association.

### Installation

@verbatim
<code-snippet name="Install the plugin" lang="bash">
composer require jeffersongoncalves/filament-keyable:^2.0
</code-snippet>
@endverbatim

Publish config files:

@verbatim
<code-snippet name="Publish config files" lang="bash">
php artisan vendor:publish --provider="Givebutter\LaravelKeyable\KeyableServiceProvider"
php artisan vendor:publish --tag=filament-keyable-config
</code-snippet>
@endverbatim

### Register Plugin

@verbatim
<code-snippet name="Register in PanelProvider" lang="php">
use JeffersonGoncalves\Filament\Keyable\KeyablePlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            KeyablePlugin::make(),
        ]);
}
</code-snippet>
@endverbatim

### Configure Models

@verbatim
<code-snippet name="Configure keyable models in config" lang="php">
// config/filament-keyable.php
return [
    'api_key_resource' => [
        'cluster' => null,
        'model' => \Givebutter\LaravelKeyable\Models\ApiKey::class,
        'should_register_navigation' => true,
        'navigation_badge' => true,
        'navigation_icon' => 'heroicon-o-key',
        'navigation_sort' => -1,
        'slug' => 'settings/api-keys',
        'models' => [
            // \App\Models\User::class,
            // \App\Models\Customer::class,
        ],
    ],
];
</code-snippet>
@endverbatim

### Features
- Filament Resource for API key management (list, create, view)
- Polymorphic model association via `MorphToSelect`
- Configurable navigation (icon, sort, badge, group, slug)
- Copyable API key display in the infolist view
- Navigation badge showing total API key count
- Support for resource clusters
- Fully configurable via `config/filament-keyable.php`
- Supports translations via language files (`filament-keyable::filament-keyable.*`)

### Architecture
- `KeyablePlugin` implements `Filament\Contracts\Plugin` and registers `KeyableResource`
- `KeyableResource` extends `Filament\Resources\Resource` with pages: List, Create, View
- Form schema handled by `KeyableForm` (name + MorphToSelect)
- Table schema handled by `KeyablesTable` (name, keyable_id, keyable_type, last_used_at)
- Infolist schema handled by `KeyableInfolist` (name, key with copyable, keyable_id, keyable_type)
- Configuration centralized in `Utils` helper class reading from `config('filament-keyable.*')`

### Best Practices
- Configure the `models` array in the config file to define which models can have API keys
- Set `allow_empty_models` to `true` in the keyable config if models should be optional
- Use the `cluster` config option to group the API key resource under a Filament cluster
- Customize the `slug` to place the API keys page at a specific URL path
