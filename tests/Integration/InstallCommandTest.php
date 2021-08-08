<?php

namespace Oneofftech\LaravelLanguageRecognizer\Tests\Integration;

use Illuminate\Support\Facades\Artisan;

class InstallCommandTest extends TestCase
{
    /** @test */
    public function download_the_franc_binary_to_custom_path()
    {
        $exit = Artisan::call('language-recognizer:install-local-driver', ['--path' => __DIR__ . '/../../bin/language-guesser']);

        $this->assertEquals(0, $exit);
        $this->assertFileExists(__DIR__ . '/../../bin/language-guesser' . (strtolower(PHP_OS) === 'winnt' ? '.exe' : ''));
    }

    /** @test */
    public function download_the_franc_binary_to_default_path()
    {
        $this->app['config']->set('language-recognizer.drivers.local.path', './bin/language-guesser');

        $exit = Artisan::call('language-recognizer:install-local-driver');

        $this->assertEquals(0, $exit);
        $this->assertFileExists(base_path('bin/language-guesser') . (strtolower(PHP_OS) === 'winnt' ? '.exe' : ''));
    }
}
