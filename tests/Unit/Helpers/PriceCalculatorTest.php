<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use App\Helpers\PriceCalculator;

class PriceCalculatorTest extends TestCase
{
    public function test_modify_by_percent()
    {
        // priceTax, tax, percent, resultNoTax
        $tests = [
            [120, 20, -10, 90],
            [120, 20, 0, 100],
        ];

        foreach ($tests as $test) {
            list($input, $tax, $percent, $expectedResult) = $test;

            $this->assertEquals($expectedResult, PriceCalculator::modifyByPercent($input, $percent, $tax));
        }
    }
}
