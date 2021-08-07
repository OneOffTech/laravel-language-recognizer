<?php

namespace Oneofftech\LaravelLanguageRecognizer\Contracts;

interface LanguageRecognizer
{
    /**
     * Recognize the language of the given text
     *
     * @param string $text The text to recognize
     * @param int $limit The number of languages to return. Default 2. Use 1 to get only the most probable
     * @return array The identified languages together with the confidence score. Returned as an associative array keyed by ISO 639-1 code and with value the confidence score extpressed between 0 and 1
     */
    public function recognize($text, $limit = 2): array;
}
