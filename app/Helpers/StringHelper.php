<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * @param  string  $string
     *
     * @return string|string[]|null
     */
    public static function keepLettersAndNumbers(string $string)
    {
        // keep only letters (even cyrillic) and numbers
        return preg_replace('/\s(\S*)\s/u', '', $string);
    }
}
