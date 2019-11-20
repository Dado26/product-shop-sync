<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * @param  string  $string
     *
     * @return string|string[]|null
     */
    public static function removeAllWhitespaces(string $string)
    {
        $string = preg_replace('/\s*$^\s*/m', "\n", $string);

        return preg_replace('/[ \t]+/', ' ', $string);
    }
}
