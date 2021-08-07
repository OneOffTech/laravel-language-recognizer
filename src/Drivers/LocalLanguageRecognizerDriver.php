<?php

namespace Oneofftech\LaravelLanguageRecognizer\Drivers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Oneofftech\LaravelLanguageRecognizer\LaravelLanguageRecognizer;
use Oneofftech\LaravelLanguageRecognizer\Contracts\LanguageRecognizer;
use RuntimeException;

class LocalLanguageRecognizerDriver implements LanguageRecognizer
{
    
    public function __construct($config)
    {
        
        if(empty($config['path'])){
            throw new InvalidArgumentException("Null binary path");
        }
        
        $this->binaryPath = $this->obtainBinaryPath($config['path']);
    }

    protected function obtainBinaryPath($configuredPath)
    {
        $basePath = Str::startsWith($configuredPath, '.') ? base_path($configuredPath) : $configuredPath;

        // $basePath = realpath($resolvedPath);

        // if($basePath === false){
        //     throw new InvalidArgumentException("Specified path [{$resolvedPath}] cannot be resolved to a valid, existing path.");
        // }

        $suffixes = [
            '',
            '.exe',
            '-win.exe',
            '-linux',
            '-macos',
        ];

        foreach ($suffixes as $suffix) {
            if (@is_file($file = realpath($basePath.$suffix)) && ('\\' === DIRECTORY_SEPARATOR || is_executable($file))) {
                return $file;
            }
        }

        throw new InvalidArgumentException("Specified binary [{$basePath}] does not exists or is not executable.");
    }


    /**
     * @inherit
     */
    public function recognize($text, $limit = 2): array
    {
        $out = $this->run($text);

        return Str::of($out)
            ->trim()
            ->explode("\n")
            ->take($limit)
            ->mapWithKeys(function($l){

                list($lang, $probability) = explode(" ", $l);

                return [$lang => (float)$probability];
            })->toArray();
    }


    private function run($text)
    {
        $options = [$this->binaryPath, '--all'];

        // if (! empty($this->blacklist)) {
        //     $options[] = '--ignore';
        //     $options[] = join(',', Arr::wrap($this->blacklist));
        // }

        // if (! empty($this->whitelist)) {
        //     $options[] = '--only';
        //     $options[] = join(',', Arr::wrap($this->whitelist));
        // }

        $process = new Process(
            $options,
            realpath(dirname($this->binaryPath))
        );

        $process->setInput($text);
        
        $process->setTimeout(10);
        $process->setIdleTimeout(10);

        try {
            $process->mustRun();

            if (! $process->isSuccessful()) {
                throw new Exception((new ProcessFailedException($process))->getMessage());
            }
        } catch (ProcessFailedException $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode(), $ex);
        }

        return $process->getOutput();
    }

}
