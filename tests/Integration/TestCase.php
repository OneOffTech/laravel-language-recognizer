<?php

namespace Oneofftech\LaravelLanguageRecognizer\Tests\Integration;

use Oneofftech\LaravelLanguageRecognizer\LaravelLanguageRecognizerServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelLanguageRecognizerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
