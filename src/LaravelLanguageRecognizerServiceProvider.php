<?php

namespace Oneofftech\LaravelLanguageRecognizer;

use Illuminate\Support\ServiceProvider;
use Oneofftech\LaravelLanguageRecognizer\Commands\InstallLocalRecognizerCommand;

class LaravelLanguageRecognizerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {

            $this->commands([
                InstallLocalRecognizerCommand::class,
            ]);
            
            $this->publishes([
                __DIR__.'/../config/language-recognizer.php' => config_path('language-recognizer.php'),
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/language-recognizer.php',
            'language-recognizer'
        );

        $this->app->singleton(LaravelLanguageRecognizer::class, function ($app) {
            return new LaravelLanguageRecognizer($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [LaravelLanguageRecognizer::class];
    }

    /**
     * Determine if the provider is deferred.
     *
     * @return bool
     */
    public function isDeferred()
    {
        return true;
    }
}
