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
        return preg_replace('/[^a-zA-Z0-9]/', '', $string);
    }
}
