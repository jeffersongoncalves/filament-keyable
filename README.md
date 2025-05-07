<div class="filament-hidden">

![Filament Keyable](https://raw.githubusercontent.com/jeffersongoncalves/filament-keyable/master/art/jeffersongoncalves-filament-keyable.png)

</div>

# Filament Keyable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/filament-keyable.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-keyable)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/filament-keyable/fix-php-code-style-issues.yml?branch=master&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/filament-keyable/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/filament-keyable.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-keyable)

This is a Laravel Filament package that provides API Key management functionality for any model in your web application.
Built on top of the `givebutter/laravel-keyable` library, this plugin allows you to associate incoming requests with
their respective models and manage API key authorization through Policies. The package seamlessly integrates these
features into the Filament admin panel interface.

### Key Features

- Integration with the Laravel Filament framework
- Admin interface for managing API keys
- Easy implementation through a configurable plugin
- Support for model-specific API keys
- Request authorization via Policies

### How It Works

The package provides a plugin for Filament that can be easily integrated into your admin panel. It uses the foundation
of the `givebutter/laravel-keyable` library to add API key capabilities to any model in your application while providing
a user-friendly interface for key management through Filament.
This solution is ideal for:

- API authentication
- Request authorization
- Secure model access
- Data migrations

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/filament-keyable
```

## Usage

Publish config file.

```bash
php artisan vendor:publish --tag=filament-keyable-config
```

Add in AdminPanelProvider.php

```php
use JeffersonGoncalves\Filament\Keyable\KeyablePlugin;

->plugins([
    KeyablePlugin::make(),
])
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jèfferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
