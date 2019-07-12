<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ChangeDetectorService;

class ChangeDetectorServiceTest extends TestCase
{
    public function testIntersectionBetweenTwoArrays()
    {
        $result = ChangeDetectorService::getIntersection(
            ['white', 'red', 'green', 'blue'], 
            ['black', 'red', 'pink', 'green']
        );

        $this->assertEquals(['red', 'green'], $result);
    }

    public function testThatFirstArrayIsReturnedWithoutItemsFromSecondArray()
    {
        $result = ChangeDetectorService::getArrayWithoutItemsFromSecondArray(
            ['white', 'red', 'green', 'blue'], 
            ['black', 'red', 'pink', 'green']
        );

        $this->assertEquals(['white', 'blue'], $result);
    }

    public function testThatSecondArrayIsReturnedWithoutItemsFromFirstArray()
    {
        $result = ChangeDetectorService::getArrayWithoutItemsFromFirstArray(
            ['white', 'red', 'green', 'blue'], 
            ['black', 'red', 'pink', 'green']
        );

        $this->assertEquals(['black', 'pink'], $result);
    }
}
