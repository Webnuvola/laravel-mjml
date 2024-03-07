# Changelog

All notable changes to `webnuvola/laravel-mjml` will be documented in this file.

## v1.0.1 - 2024-03-07
Remove `extra` property from `composer.json`

## v1.0.0 - 2024-03-07

- Support for Laravel 9 - 11 and PHP 8.1 - 8.3
- Use `spatie/mjml-php` package
- Add tests with Pest

## Upgrading from v0.4.0 to v1.0.0
Version v1.0.0 is compatible with Mailables defined with version v0.4.0, but you have to replace `Asahasrabuddhe\LaravelMJML\Mail\Mailable` with `Webnuvola\Laravel\Mjml\Mailable` class.

This package uses [`spatie/mjml-php`](https://github.com/spatie/mjml-php) under the hood. In your project, or on your server, you must have the JavaScript package [`mjml`](https://github.com/mjmlio/mjml) installed.
