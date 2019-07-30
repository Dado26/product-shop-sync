<?php

namespace App\Helpers;

class PriceCalculator
{
    /**
     * @param float $price
     * @param float $percent
     *
     * @return float
     */
    public static function modifyByPercent($price, $percent): float
    {
        if ($percent == 0) {
            return $price;
        }
        $priceModified   = (abs($percent) / 100) * $price;
        if ($percent > 0) {
            return $priceModified + $price;
        }
        if ($percent < 0) {
            return $price - $priceModified;
        }
    }
}