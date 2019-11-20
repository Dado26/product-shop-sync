<?php

namespace App\Helpers;

class String
{
    /**
     * @param string $string
     */
    public static function removeAllWhitespaces(string $string)
    {
        $string = preg_replace('/\s*$^\s*/m', "\n", $string);

        return preg_replace('/[ \t]+/', ' ', $string);
    }
}
