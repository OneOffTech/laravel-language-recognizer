# Laravel Language Recognizer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/oneofftech/laravel-language-recognizer.svg?style=flat-square)](https://packagist.org/packages/oneofftech/laravel-language-recognizer)
[![Unit tests badge](https://github.com/OneOffTech/laravel-language-recognizer/actions/workflows/run-tests.yml/badge.svg)](https://github.com/OneOffTech/laravel-language-recognizer/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/oneofftech/laravel-language-recognizer.svg?style=flat-square)](https://packagist.org/packages/oneofftech/laravel-language-recognizer)


Recognize the language in which a text is written.

Language Recognizer for Laravel is a package providing various drivers to recognize the language of a
given text.

Currently two drivers are offered:

- A local binary application
- A [DeepL](https://www.deepl.com/) based one

## Installation

You can install the package via composer:

```bash
composer require oneofftech/laravel-language-recognizer
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Oneofftech\LaravelLanguageRecognizer\LaravelLanguageRecognizerServiceProvider" --tag="laravel-language-recognizer-config"
```

> If you change the path to the Franc binary, as configured in the local driver, ensure that the file is moved or present in that location. You can run `php artisan language-recognizer:install-local-driver` to download the binary in the configured location

The configuration file allows to configure the driver parameter for
performing the language recognition.

### Driver pre-requisites

**Local Driver**

The language recognition, when performed using the local driver, 
is done using the [Franc](https://github.com/wooorm/franc) library, in particular
a [packaged version](https://github.com/avvertix/franc-bin) in form on an executable. 

To download the executable version run:

```bash
php artisan language-recognizer:install-local-driver
```

**DeepL Driver**

The [DeepL](https://www.deepl.com/) driver requires a valid API key.
You can obtain a free key on [deepl.com](https://www.deepl.com/pro#developer).

After obtaining the key specifiy it via the `LANGUAGE_RECOGNIZER_DEEPL_KEY` environment variable.


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
- [All Contributors](https://github.com/OneOffTech/laravel-language-recognizer/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
