<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\ChangeDetectorService;

class ChangeDetectorServiceTest extends TestCase
{
    public function test_intersection_between_two_arrays()
    {
        $result = ChangeDetectorService::getIntersection(
            ['white', 'red', 'green', 'blue'],
            ['black', 'red', 'pink', 'green']
        );

        $this->assertEquals(['red', 'green'], $result);
    }

    public function test_that_first_array_is_returned_without_items_from_second_array()
    {
        $result = ChangeDetectorService::getArrayWithoutItemsFromSecondArray(
            ['white', 'red', 'green', 'blue'],
            ['black', 'red', 'pink', 'green']
        );

        $this->assertEquals(['white', 'blue'], $result);
    }

    public function test_that_second_array_is_returned_without_items_from_first_array()
    {
        $result = ChangeDetectorService::getArrayWithoutItemsFromFirstArray(
            ['white', 'red', 'green', 'blue'],
            ['black', 'red', 'pink', 'green']
        );

        $this->assertEquals(['black', 'pink'], $result);
    }
}
