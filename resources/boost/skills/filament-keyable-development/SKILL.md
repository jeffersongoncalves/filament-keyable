---
name: filament-keyable-development
description: Build and work with Filament Keyable plugin features, including API key management, polymorphic model association, resource configuration, and key authorization.
---

# Filament Keyable Development

## When to use this skill

Use this skill when:
- Adding API key management to a Filament panel
- Customizing the API key resource (form, table, infolist)
- Configuring polymorphic model association for API keys
- Working with the `KeyablePlugin`, `KeyableResource`, or related classes
- Adjusting navigation, clustering, or slug settings for the API key resource
- Integrating with `givebutter/laravel-keyable` for API authentication

## Package Overview

- **Package**: `jeffersongoncalves/filament-keyable` (branch `3.x` for Filament 5)
- **Namespace**: `JeffersonGoncalves\Filament\Keyable`
- **Dependencies**: `filament/filament:^5.0`, `givebutter/laravel-keyable:^3.1`, `spatie/laravel-package-tools:^1.14.0`
- **Service Provider**: `JeffersonGoncalves\Filament\Keyable\KeyableServiceProvider`
- **Config**: `config/filament-keyable.php`

## Version Compatibility

| Branch | Filament | PHP | Laravel |
|--------|----------|-----|---------|
| 1.x | 3.x | ^8.2 | ^11.0 |
| 2.x | 4.x | ^8.2 | ^11.0 |
| 3.x | 5.x | ^8.2 | ^11.0 |

## Configuration

### Basic Setup

Register the plugin in your `PanelProvider`:

```php
use JeffersonGoncalves\Filament\Keyable\KeyablePlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            KeyablePlugin::make(),
        ]);
}
```

### Publish Config Files

```bash
php artisan vendor:publish --provider="Givebutter\LaravelKeyable\KeyableServiceProvider"
php artisan vendor:publish --tag=filament-keyable-config
```

### Config File (`config/filament-keyable.php`)

```php
use Givebutter\LaravelKeyable\Models\ApiKey;

return [
    'api_key_resource' => [
        'cluster' => null,
        'model' => ApiKey::class,
        'should_register_navigation' => true,
        'navigation_badge' => true,
        'navigation_icon' => 'heroicon-o-key',
        'navigation_sort' => -1,
        'slug' => 'settings/api-keys',
        'models' => [
            // App\Models\User::class,
            // App\Models\Customer::class,
        ],
    ],
];
```

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `cluster` | `?string` | `null` | Filament cluster to group the resource under |
| `model` | `string` | `ApiKey::class` | Eloquent model for API keys |
| `should_register_navigation` | `bool` | `true` | Show in navigation sidebar |
| `navigation_badge` | `bool` | `true` | Show count badge in navigation |
| `navigation_icon` | `string` | `heroicon-o-key` | Navigation icon |
| `navigation_sort` | `?int` | `-1` | Navigation sort order |
| `slug` | `string` | `settings/api-keys` | URL slug for the resource |
| `models` | `array` | `[]` | Models that can have API keys (MorphToSelect options) |

## Architecture

### Plugin Class (`KeyablePlugin`)

```php
namespace JeffersonGoncalves\Filament\Keyable;

use Filament\Contracts\Plugin;
use Filament\Panel;
use JeffersonGoncalves\Filament\Keyable\Resources\Keyables\KeyableResource;
use JeffersonGoncalves\Filament\Keyable\Support\Utils;

class KeyablePlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'filament-keyable';
    }

    public function register(Panel $panel): void
    {
        if (! Utils::isResourcePublished($panel)) {
            $panel->resources([KeyableResource::class]);
        }
    }

    public function boot(Panel $panel): void {}
}
```

The plugin checks if a custom `KeyableResource` has already been published before registering the default one, allowing users to override the resource entirely.

### Resource Class (`KeyableResource`)

```php
namespace JeffersonGoncalves\Filament\Keyable\Resources\Keyables;

use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Schemas\KeyableForm;
use JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Schemas\KeyableInfolist;
use JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Tables\KeyablesTable;
use JeffersonGoncalves\Filament\Keyable\Support\Utils;

class KeyableResource extends Resource
{
    public static function form(Schema $schema): Schema
    {
        return KeyableForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return KeyableInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KeyablesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeyables::route('/'),
            'create' => Pages\CreateKeyable::route('/create'),
            'view' => Pages\ViewKeyable::route('/{record}'),
        ];
    }

    public static function getModel(): string
    {
        return Utils::getKeyableModel();
    }
}
```

### Form Schema (`KeyableForm`)

```php
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
}
```

### Table Schema (`KeyablesTable`)

```php
namespace JeffersonGoncalves\Filament\Keyable\Resources\Keyables\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use JeffersonGoncalves\Filament\Keyable\Support\Utils;

class KeyablesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(fn () => __('filament-keyable::filament-keyable.column.name')),
                TextColumn::make('keyable_id')
                    ->label(fn () => __('filament-keyable::filament-keyable.column.keyable_id'))
                    ->hidden(fn () => Utils::isAllowEmptyModels()),
                TextColumn::make('keyable_type')
                    ->label(fn () => __('filament-keyable::filament-keyable.column.keyable_type'))
                    ->hidden(fn () => Utils::isAllowEmptyModels()),
                TextColumn::make('last_used_at')
                    ->label(fn () => __('filament-keyable::filament-keyable.column.last_used_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
```

### Infolist Schema (`KeyableInfolist`)

```php
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
```

### Utils Helper Class

```php
namespace JeffersonGoncalves\Filament\Keyable\Support;

use Filament\Panel;
use Givebutter\LaravelKeyable\Models\ApiKey;

class Utils
{
    public static function isResourcePublished(Panel $panel): bool;
    public static function getResourceCluster(): ?string;
    public static function isAllowEmptyModels(): bool;
    public static function getModels(): array;
    public static function getKeyableModel(): string;
    public static function isResourceNavigationRegistered(): bool;
    public static function isResourceNavigationGroupEnabled(): bool;
    public static function getResourceNavigationSort(): ?int;
    public static function getResourceNavigationIcon(): string;
    public static function getResourceSlug(): string;
    public static function isResourceNavigationBadgeEnabled(): bool;
}
```

All methods read from `config('filament-keyable.api_key_resource.*')` or `config('keyable.*')`.

## Resource Pages

| Page | Class | Route |
|------|-------|-------|
| List | `Pages\ListKeyables` | `/` |
| Create | `Pages\CreateKeyable` | `/create` |
| View | `Pages\ViewKeyable` | `/{record}` |

Note: There is no Edit page -- API keys are created and viewed only.

## Translations

Translations are loaded from `filament-keyable::filament-keyable.*` namespace. Key translation keys:
- `filament-keyable::filament-keyable.resource.label.keyable`
- `filament-keyable::filament-keyable.resource.label.keyables`
- `filament-keyable::filament-keyable.nav.group`
- `filament-keyable::filament-keyable.nav.keyable.label`
- `filament-keyable::filament-keyable.column.name`
- `filament-keyable::filament-keyable.column.keyable`
- `filament-keyable::filament-keyable.column.keyable_id`
- `filament-keyable::filament-keyable.column.keyable_type`
- `filament-keyable::filament-keyable.column.last_used_at`
- `filament-keyable::filament-keyable.infolist.name`
- `filament-keyable::filament-keyable.infolist.key`
- `filament-keyable::filament-keyable.infolist.copy_message`

## Troubleshooting

### MorphToSelect shows no model options
**Cause**: The `models` array in `config/filament-keyable.php` is empty.
**Solution**: Add model classes to the `models` array:
```php
'models' => [
    App\Models\User::class,
    App\Models\Customer::class,
],
```

### MorphToSelect is hidden
**Cause**: `allow_empty_models` is set to `true` in the `keyable` config.
**Solution**: Set `allow_empty_models` to `false` in `config/keyable.php` if you want to require model association.

### Navigation badge not showing
**Cause**: The `navigation_badge` config option is set to `false`.
**Solution**: Set `navigation_badge` to `true` in `config/filament-keyable.php`.

### Resource not appearing in panel
**Cause**: A custom `KeyableResource` was published and the plugin detected it, skipping default registration.
**Solution**: The plugin uses `Utils::isResourcePublished()` to check if a resource containing `KeyableResource` in its class name already exists. If you published a custom resource, ensure it is properly configured.

### API key not copyable in view page
**Cause**: The infolist is not rendering the `key` field.
**Solution**: The `key` field in `KeyableInfolist` uses `->copyable()` which renders a copy button. Ensure JavaScript is loaded correctly in your panel.
