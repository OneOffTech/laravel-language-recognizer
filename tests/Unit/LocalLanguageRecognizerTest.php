<?php

namespace Oneofftech\LaravelLanguageRecognizer\Tests\Unit;

use InvalidArgumentException;
use Oneofftech\LaravelLanguageRecognizer\Drivers\LocalLanguageRecognizerDriver;
use PHPUnit\Framework\TestCase;

class LocalLanguageRecognizerTest extends TestCase
{
    /** @test */
    public function throws_if_path_missing()
    {
        $this->expectException(InvalidArgumentException::class);

        new LocalLanguageRecognizerDriver([
            'path' => null,
        ]);
    }

    /** @test */
    public function throws_if_path_empty()
    {
        $this->expectException(InvalidArgumentException::class);

        new LocalLanguageRecognizerDriver([
            'path' => '   ',
        ]);
    }

    /** @test */
    public function throws_if_path_refer_to_non_existing_binary()
    {
        $this->expectException(InvalidArgumentException::class);

        new LocalLanguageRecognizerDriver([
            'path' => __DIR__ . '/../../bin/language-what',
        ]);
    }

    /** @test */
    public function it_can_recognize_a_string()
    {
        $driver = new LocalLanguageRecognizerDriver([
            'path' => __DIR__ . '/../../bin/language-recognizer',
        ]);

        $languages = $driver->recognize('This should be an english string');

        $this->assertEquals([
            "sco" => 1.0,
            "eng" => 0.98693181818182,
          ], $languages);
    }

    /** @test */
    public function it_respect_the_given_limit()
    {
        $driver = new LocalLanguageRecognizerDriver([
            'path' => __DIR__ . '/../../bin/language-recognizer',
        ]);

        $languages = $driver->recognize('This should be an english string', 10);

        $this->assertCount(10, $languages);
    }

    /** @test */
    public function it_handles_punctuation()
    {
        $driver = new LocalLanguageRecognizerDriver([
            'path' => __DIR__ . '/../../bin/language-recognizer',
        ]);

        $languages = $driver->recognize(",./;'[]\-=", 1);

        $this->assertCount(1, $languages);
    }

    /** @test */
    public function it_handles_bash()
    {
        $driver = new LocalLanguageRecognizerDriver([
            'path' => __DIR__ . '/../../bin/language-recognizer',
        ]);

        $languages = $driver->recognize('!@#$%^&*()`~', 1);

        $this->assertCount(1, $languages);
    }

    /** @test */
    public function it_handles_utf8()
    {
        $driver = new LocalLanguageRecognizerDriver([
            'path' => __DIR__ . '/../../bin/language-recognizer',
        ]);

        $languages = $driver->recognize('Ω≈ç√∫˜µ≤≥÷', 1);

        $this->assertCount(1, $languages);
    }

    /** @test */
    public function it_handles_utf8_c()
    {
        $driver = new LocalLanguageRecognizerDriver([
            'path' => __DIR__ . '/../../bin/language-recognizer',
        ]);

        $languages = $driver->recognize('찦차를 타고 온 펲시맨과 쑛다리 똠방각하', 1);

        $this->assertCount(1, $languages);
    }

    /** @test */
    public function it_handles_emoji()
    {
        $driver = new LocalLanguageRecognizerDriver([
            'path' => __DIR__ . '/../../bin/language-recognizer',
        ]);

        $languages = $driver->recognize('🐵 🙈 🙉 🙊', 1);

        $this->assertCount(1, $languages);
    }
}
