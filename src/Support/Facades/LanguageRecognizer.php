<?php

namespace Oneofftech\LaravelLanguageRecognizer\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Oneofftech\LaravelLanguageRecognizer\LaravelLanguageRecognizer;

/**
 * @method static array recognize(string $text, $limit = 2)
 * @method static \Oneofftech\LaravelLanguageRecognizer\Contracts\LanguageRecognizer driver(string|null $driver = null)
 *
 * @see \Oneofftech\LaravelLanguageRecognizer\LaravelLanguageRecognizer
 */
class LanguageRecognizer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LaravelLanguageRecognizer::class;
    }
}
