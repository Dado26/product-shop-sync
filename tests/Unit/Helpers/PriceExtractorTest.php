<?php

namespace Tests\Unit\Helpers;

use App\Helpers\PriceExtractor;
use Tests\TestCase;

class PriceExtractorTest extends TestCase
{
    public function test_all_known_price_strings()
    {
        $tests = [
            ['1000.00', '1000', 0],
            ['1000.00', '1000,0', 1],
            ['1000.00', '1000.0', 1],
            ['1000.00', '1000.00', 2],
            ['1000.00', '1000,00', 2],
            ['10000.00', '10000.00', 2],
            ['10000.00', '10000,00', 2],
            ['10000.00', '10.000,00', 2],
            ['10000.00', '10,000.00', 2],
            ['10000.00', '10000,00 din', 2],
            ['10000.00', '10000 din', 0],
            ['10000.00', 'din 10000', 0],
            ['10000.00', 'din 10000.00', 2],
            ['10000.00', 'din 10000,00', 2],
            ['10000.00', 'rsd 10000,00', 2],
            ['10000.00', '<span>10000,00</span>', 2],
            ['450.00', '<span><span class="old-price">500,00</span>          450,00               </span>', 2],
        ];

        foreach ($tests as $test) {
            $expectedResult = $test[0];
            $input          = $test[1];
            $decimals       = $test[2];

            $this->assertEquals($expectedResult, PriceExtractor::handle($input, $decimals));
        }
    }
}
