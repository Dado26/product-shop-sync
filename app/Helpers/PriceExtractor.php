<?php

namespace App\Helpers;

class PriceExtractor
{
    public static function handle(string $price, int $decimals = 0)
    {
        // remove html tags
        $price = strip_tags($price);

        // remove duplicate whitespaces
        $price = preg_replace('/^\s+|\s+$|\s+(?=\s)/', '', $price);

        // explode to array by space
        $prices = explode(' ', $price);

        // map and get min number
        $price = collect($prices)->map(function ($price) {
            // remove percentage (like 15%) so it won't be used as a minimum price
            $string = preg_replace('/\d+%/', '', $price);

            return (int) preg_replace("/[^0-9]/", '', $string);
        })->filter()->min();

        // get number for division
        $divide = '1'.str_repeat('0', $decimals);

        // calculate final price
        $price = $price / $divide;

        // limit result to 2 decimals
        return number_format($price, 2, '.', '');
    }
}
