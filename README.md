# Laravel MJML
[![Latest Version on Packagist](https://img.shields.io/packagist/v/webnuvola/laravel-mjml.svg?style=flat-square)](https://packagist.org/packages/webnuvola/laravel-mjml)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/webnuvola/laravel-mjml/run-tests.yml?branch=main)](https://github.com/webnuvola/laravel-mjml/actions/workflows/run-tests.yml?query=branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/webnuvola/laravel-mjml.svg?style=flat-square)](https://packagist.org/packages/webnuvola/laravel-mjml)

Effortlessly craft responsive email templates using MJML within Laravel Mailables.

To use this package, follow these steps after generating a new Mailable.  
Instead of extending `Illuminate\Mail\Mailable`, extend `Webnuvola\Laravel\Mjml\Mailable`.  
In the Mailable class, define the `build` method.  
You can now use the `mjml` method for defining a view or `mjmlContent` to directly pass the MJML template.

Here's an example:

```php
use Webnuvola\Laravel\Mjml\Mailable;

class TestMail extends Mailable
{
    /**
     * Build the message.
     */
    public function build(): void
    {
        return $this->mjml('emails.orders.shipped', [
            'order' => $order,
        ]);
    }
}
```

## Installation

You can install the package via composer:

```bash
composer require webnuvola/laravel-mjml
```

In your project, or on your server, you must have the JavaScript package [`mjml`](https://github.com/mjmlio/mjml) installed.

```bash
npm install mjml
```

Make sure you have installed Node 16 or higher.  
This package uses [`spatie/mjml-php`](https://github.com/spatie/mjml-php) under the hood.


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Fabio Cagliero](https://github.com/fab120)

Inspired by [asahasrabuddhe/laravel-mjml](https://github.com/asahasrabuddhe/laravel-mjml) package.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
