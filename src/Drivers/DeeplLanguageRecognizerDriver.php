<?php

namespace Oneofftech\LaravelLanguageRecognizer\Drivers;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Oneofftech\LaravelLanguageRecognizer\Contracts\LanguageRecognizer;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DeeplLanguageRecognizerDriver implements LanguageRecognizer
{

    protected string $host;

    protected string $token;

    public function __construct($config)
    {
        if (empty($config['host'] ?? null)) {
            throw new InvalidArgumentException("Invalid host");
        }
        
        if (empty($config['key'] ?? null)) {
            throw new InvalidArgumentException("Invalid authentication key");
        }
        
        if (empty(trim($config['host']))) {
            throw new InvalidArgumentException("Invalid host");
        }

        if (empty(trim($config['key']))) {
            throw new InvalidArgumentException("Invalid authentication key");
        }

        $this->host = rtrim($config['host'], '/');
        $this->token = $config['key'];
    }


    /**
     * @inherit
     */
    public function recognize($text, $limit = 2): array
    {
        $response = Http::acceptJson()
            ->asForm()
            ->withToken($this->token, 'DeepL-Auth-Key')
            ->post("{$this->host}/v2/translate", [
                'text' => $text,
                'target_lang' => 'EN-US',
            ])
            ->throw();

        $json = $response->json();

        $detectedLanguage = $json['translations'][0]['detected_source_language'] ?? null;

        if(is_null($detectedLanguage)){
            throw new Exception('Failed to obtain detected language from DeepL API');
        }

        if(in_array($detectedLanguage, ['EN-US', 'EN-GB'])){
            $detectedLanguage = 'EN';
        }

        return [
            $detectedLanguage => 1.0
        ];
    }

    
}
