<?php

namespace Oneofftech\LaravelLanguageRecognizer\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class InstallLocalRecognizerCommand extends Command
{
    public $signature = 'language-recognizer:install-local-driver {--path=}';

    public $description = 'Install the local Franc binary used to recognize the language of a text';


    /**
     * Artifacts urls keyed based on operating system
     * 
     * @var array
     */
    protected static $urls = [
        'linux' => 'https://github.com/avvertix/franc-bin/releases/download/v1.0.0/franc-bin-linux',
        'darwin' => 'https://github.com/avvertix/franc-bin/releases/download/v1.0.0/franc-bin-macos',
        'winnt' => 'https://github.com/avvertix/franc-bin/releases/download/v1.0.0/franc-bin-win.exe',
    ];


    /**
     * @return int
     *
     */
    public function handle()
    {
        $this->comment('Downloading Franc from binary from https://github.com/avvertix/franc-bin');

        $os = $this->getOs();
        
        $url = self::$urls[$os] ?? null;
        
        if(is_null($url)){
            throw new Exception("Unsupported operating system [{$os}]");
        }

        $this->info($url);

        $downloadPath = $this->getDownloadPath();

        if(!is_dir($directory = dirname($downloadPath))){
            mkdir($directory);
        }

        Http::withOptions([
            'sink' => $downloadPath,
        ])->timeout(30)->get($url);

        $this->comment('All done');

        return 0;
    }

    protected function getOs()
    {
        return strtolower(PHP_OS);
    }

    protected function getDownloadPath()
    {
        $pathOption = $this->option('path');
        
        if($pathOption){

            if($this->getOs() === 'winnt' && ! Str::endsWith($pathOption, '.exe')){
                return $pathOption.'.exe';
            }

            return $pathOption;
        }
        
        $suffixes = [
            'winnt' => '.exe',
        ];

        $configuredPath = config('language-recognizer.drivers.local.path');

        $resolvedPath = Str::startsWith($configuredPath, '.') ? base_path($configuredPath) : $configuredPath;

        return $resolvedPath . ($suffixes[$this->getOs()] ?? '');
    }
}