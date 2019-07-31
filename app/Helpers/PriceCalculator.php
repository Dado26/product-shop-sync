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

        $pricePercentage = (abs($percent) / 100) * $price;

        if ($percent > 0) {
            $priceModified =  $pricePercentage + $price;
            return round($priceModified);
        }
        if ($percent < 0) {
            $priceModified =  $price - $pricePercentage;
            return round($priceModified);
        }
    }
}
