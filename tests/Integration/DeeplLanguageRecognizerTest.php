<?php

namespace Oneofftech\LaravelLanguageRecognizer\Tests\Unit;

use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Oneofftech\LaravelLanguageRecognizer\Drivers\DeeplLanguageRecognizerDriver;
use Oneofftech\LaravelLanguageRecognizer\Tests\Integration\TestCase;

class DeeplLanguageRecognizerTest extends TestCase
{
    /** @test */
    public function throws_if_host_empty()
    {
        $this->expectException(InvalidArgumentException::class);

        new DeeplLanguageRecognizerDriver([
            'host' => '    ',
            'key' => 'a-value',
        ]);
    }

    /** @test */
    public function throws_if_key_empty()
    {
        $this->expectException(InvalidArgumentException::class);

        new DeeplLanguageRecognizerDriver([
            'key' => '   ',
            'host' => 'https://a-domain',
        ]);
    }


    /** @test */
    public function it_can_recognize_a_string()
    {
        Http::preventStrayRequests();

        Http::fake([
            'https://api-free.deepl.com/*' => Http::response('{"translations": [{"detected_source_language": "EN","text": "This should be an english string"}]}', 200)
        ]);


        $driver = new DeeplLanguageRecognizerDriver([
            'key' => 'a-value',
            'host' => 'https://api-free.deepl.com',
        ]);

        $languages = $driver->recognize('This should be an english string');

        $this->assertEquals([
            "EN" => 1.0,
          ], $languages);

        Http::assertSent(function (Request $request) {
            return $request->url() == 'https://api-free.deepl.com/v2/translate' &&
                    $request['text'] == 'This should be an english string' &&
                    $request['target_lang'] === 'EN-US';
        });
    }

}
