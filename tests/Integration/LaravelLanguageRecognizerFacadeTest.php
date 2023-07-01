<?php

namespace Oneofftech\LaravelLanguageRecognizer\Tests\Integration;

use Oneofftech\LaravelLanguageRecognizer\Drivers\DeeplLanguageRecognizerDriver;
use Oneofftech\LaravelLanguageRecognizer\Drivers\LocalLanguageRecognizerDriver;
use Oneofftech\LaravelLanguageRecognizer\Support\Facades\LanguageRecognizer;

class LaravelLanguageRecognizerFacadeTest extends TestCase
{
    /** @test */
    public function default_local_driver_can_be_obtained()
    {
        $this->app['config']->set('language-recognizer.default', 'local');
        $this->app['config']->set('language-recognizer.drivers.local.path', __DIR__ . '/../../bin/language-recognizer');

        $service = LanguageRecognizer::driver('local');

        $this->assertInstanceOf(LocalLanguageRecognizerDriver::class, $service);
    }

    /** @test */
    public function deepl_driver_can_be_obtained()
    {
        $this->app['config']->set('language-recognizer.default', 'deepl');
        $this->app['config']->set('language-recognizer.drivers.deepl.host', 'https://api-free.deepl.com');
        $this->app['config']->set('language-recognizer.drivers.deepl.key', 'a-key');

        $service = LanguageRecognizer::driver('deepl');

        $this->assertInstanceOf(DeeplLanguageRecognizerDriver::class, $service);
    }

    /** @test */
    public function recognition_can_be_done_from_facade()
    {
        $this->app['config']->set('language-recognizer.default', 'local');
        $this->app['config']->set('language-recognizer.drivers.local.path', __DIR__ . '/../../bin/language-recognizer');

        $languages = LanguageRecognizer::recognize('This is a string');

        $this->assertCount(2, $languages);
    }
}
