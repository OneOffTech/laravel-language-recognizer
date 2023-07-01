<?php

namespace Oneofftech\LaravelLanguageRecognizer;

use Illuminate\Support\Manager;
use Oneofftech\LaravelLanguageRecognizer\Drivers\DeeplLanguageRecognizerDriver;
use Oneofftech\LaravelLanguageRecognizer\Drivers\LocalLanguageRecognizerDriver;

/**
 * @method static array recognize(string $text, $limit = 2)
 *
 * @see \Oneofftech\LaravelLanguageRecognizer\Contracts\LanguageRecognizer
 * @see \Illuminate\Support\Manager
 */
class LaravelLanguageRecognizer extends Manager
{
    /**
     * Get a driver instance.
     *
     * @param  string|null  $driver
     * @return \Oneofftech\LaravelLanguageRecognizer\Contracts\LanguageRecognizer
     *
     * @throws \InvalidArgumentException
     */
    public function driver($driver = null)
    {
        return parent::driver($driver);
    }

    /**
     * @return \Oneofftech\LaravelLanguageRecognizer\Drivers\LocalLanguageRecognizerDriver
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    protected function createLocalDriver()
    {
        return new LocalLanguageRecognizerDriver($this->container['config']['language-recognizer.drivers.local']);
    }

    /**
     * @return \Oneofftech\LaravelLanguageRecognizer\Drivers\DeeplLanguageRecognizerDriver
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    protected function createDeeplDriver()
    {
        return new DeeplLanguageRecognizerDriver($this->container['config']['language-recognizer.drivers.deepl']);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function getDefaultDriver()
    {
        return $this->container['config']['language-recognizer.default'];
    }
}
