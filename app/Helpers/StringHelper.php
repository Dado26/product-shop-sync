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
        // https://stackoverflow.com/questions/49861408/remove-all-special-chars-but-not-non-latin-characters
        return preg_replace('~[^\p{Cyrillic}a-z0-9_\s-]+~ui', '', $string);
    }
}
