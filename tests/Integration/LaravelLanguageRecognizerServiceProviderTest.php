<?php

namespace Oneofftech\LaravelLanguageRecognizer\Tests\Integration;

use Oneofftech\LaravelLanguageRecognizer\Drivers\LocalLanguageRecognizerDriver;
use Oneofftech\LaravelLanguageRecognizer\LaravelLanguageRecognizer;

class LaravelLanguageRecognizerServiceProviderTest extends TestCase
{
    /** @test */
    public function can_create_a_service_instance()
    {
        $this->app['config']->set('language-recognizer.default', 'local');

        $service = $this->app[LaravelLanguageRecognizer::class];

        $this->assertInstanceOf(LaravelLanguageRecognizer::class, $service);
    }

    /** @test */
    public function default_local_driver_can_be_set()
    {
        $this->app['config']->set('language-recognizer.default', 'local');

        $service = $this->app[LaravelLanguageRecognizer::class];

        $this->assertEquals('local', $service->getDefaultDriver());
    }

    /** @test */
    public function default_local_driver_can_be_instantiated()
    {
        $this->app['config']->set('language-recognizer.default', 'local');
        $this->app['config']->set('language-recognizer.drivers.local.path', __DIR__ . '/../../bin/language-guesser');

        $service = $this->app[LaravelLanguageRecognizer::class];

        $this->assertInstanceOf(LocalLanguageRecognizerDriver::class, $service->driver());
    }
}
