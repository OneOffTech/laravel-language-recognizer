<?php

namespace Oneofftech\LaravelLanguageRecognizer\Tests\Integration;

use Oneofftech\LaravelLanguageRecognizer\Drivers\LocalLanguageRecognizerDriver;
use Oneofftech\LaravelLanguageRecognizer\Support\Facades\LanguageRecognizer;

class LaravelLanguageRecognizerFacadeTest extends TestCase
{
    /** @test */
    public function default_local_driver_can_be_obtained()
    {
        $this->app['config']->set('language-recognizer.default', 'local');
        $this->app['config']->set('language-recognizer.drivers.local.path', __DIR__ . '/../../bin/language-guesser');

        $service = LanguageRecognizer::driver('local');

        $this->assertInstanceOf(LocalLanguageRecognizerDriver::class, $service);
    }

    /** @test */
    public function recognition_can_be_done_from_facade()
    {
        $this->app['config']->set('language-recognizer.default', 'local');
        $this->app['config']->set('language-recognizer.drivers.local.path', __DIR__ . '/../../bin/language-guesser');

        $languages = LanguageRecognizer::recognize('This is a string');

        $this->assertCount(2, $languages);
    }
}
