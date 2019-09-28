<?php

namespace App\Helpers;

class PriceCalculator
{
    /**
     * @param  float  $price
     * @param  float  $percent
     * @param  float  $tax
     *
     * @return float
     */
    public static function modifyByPercent($price, $percent, $tax): float
    {
        // https://www.simetric.co.uk/si_deduct_tax.htm
        $priceNoTax = $price / (1 + ($tax/100));

        // the price that will be added or subtracted from the =price without tax
        $priceDifference = 0;

        if ($percent !== 0) {
            $priceDifference = (abs($percent) / 100) * $priceNoTax;
        }

        if ($percent > 0) {
            return round($priceDifference + $priceNoTax);
        }
        if ($percent < 0) {
            return round($priceNoTax - $priceDifference);
        }
        return $priceNoTax;
    }
}
