<?php

namespace Tests\Unit\Helpers;

use App\Helpers\PriceExtractor;
use Tests\TestCase;
use App\Helpers\SiteUrlParser;
use App\Models\Site;

class SiteUrlParserTest extends TestCase
{
    public function test_get_site_model_by_product_url()
    {
        $expectedSite = factory(Site::class)->create(['url' => 'http://test.com']);
        $foundSite    = SiteUrlParser::getSite('http://test.com/product/123');

        $this->assertEquals($expectedSite->id, $foundSite->id);
    }

    public function test_splitting_urls_by_new_line()
    {
        $tests = [
            "http://test/prod1
http://test/prod2",
            "http://test/prod1\nhttp://test/prod2",
            "http://test/prod1\n\rhttp://test/prod2",
            "http://test/prod1\n\r\n\rhttp://test/prod2",
            "http://test/prod1

http://test/prod2",
            "http://test/prod1
http://test/prod1
http://test/prod2",
        ];

        foreach ($tests as $test) {
            $this->assertEquals(['http://test/prod1', 'http://test/prod2'], SiteUrlParser::splitUrlsByNewLine($test));
        }
    }
}
