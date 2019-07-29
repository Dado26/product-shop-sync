<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use App\Helpers\PriceCalculator;

class PriceCalculatorTest extends TestCase
{
    public function test_modify_by_percent()
    {
        // price, percent, result
        $tests = [
            [100, -20, 80],
            [100, -10, 90],
            [100, -5, 95],
            [100, 0, 100],
            [100, 5, 105],
            [100, 10, 110],
            [100, 20, 120],
        ];

        foreach ($tests as $test) {
            $input          = $test[0];
            $percent        = $test[1];
            $expectedResult = $test[2];

            $this->assertEquals($expectedResult, PriceCalculator::modifyByPercent($input, $percent));
        }
    }
}
