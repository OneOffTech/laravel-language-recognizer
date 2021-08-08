# Laravel Language Recognizer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/oneofftech/laravel-language-recognizer.svg?style=flat-square)](https://packagist.org/packages/oneofftech/laravel-language-recognizer)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/oneofftech/laravel-language-recognizer/run-tests?label=tests)](https://github.com/oneofftech/laravel-language-recognizer/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/oneofftech/laravel-language-recognizer/Check%20&%20fix%20styling?label=code%20style)](https://github.com/oneofftech/laravel-language-recognizer/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/oneofftech/laravel-language-recognizer.svg?style=flat-square)](https://packagist.org/packages/oneofftech/laravel-language-recognizer)


Recognize the language in which a text is written.

## Installation

You can install the package via composer:

```bash
composer require oneofftech/laravel-language-recognizer
```

The language recognition, when performed using the local driver, 
is done using the [Franc](https://github.com/wooorm/franc) library, in particular
a [packaged version](https://github.com/avvertix/franc-bin) in form on an executable. 

To download the executable version run:

```bash
php artisan language-recognizer:install-local-driver
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Oneofftech\LaravelLanguageRecognizer\LaravelLanguageRecognizerServiceProvider" --tag="laravel-language-recognizer-config"
```

> If you change the path to the Franc binary, as configured in the local driver, ensure that the file is moved or present in that location. You can run `php artisan language-recognizer:install-local-driver` to download the binary in the configured location

This configuration file allows to specifiy the drivers for performing the language
recognition and their eventual options.

## Usage

```php
use Oneofftech\LaravelLanguageRecognizer\Support\Facades\LanguageRecognizer;

LanguageRecognizer::recognize('Which language is used in this string!');
```

## Testing

A test suite is available. To execute the tests run:

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

- [Alessio](https://github.com/avvertix)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
