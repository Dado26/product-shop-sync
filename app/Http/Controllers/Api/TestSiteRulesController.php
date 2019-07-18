<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Http\Controllers\Controller;
use App\Services\ProductCrawlerService;

class TestSiteRulesController extends Controller
{
    public function get(Request $request)
    {
        $crawler = new ProductCrawlerService;

        $crawler->handle($request->url, $request->rules);

        $values = [
            'title'          => 'getTitle',
            'description'    => 'getDescription',
            'specification'  => 'getSpecifications',
            'price'          => 'getPrice',
            'in_stock_value' => 'getInStock',
            'images'         => 'getImages',
            'variants'       => 'getVariants',
        ];

        $results = [];

        foreach ($values as $key => $methodName) {
            try {
                $results[$key] = $crawler->{$methodName}();
            } catch (InvalidArgumentException $e) {
                $results[$key] = null;
            }
        }

        return response()->json($results);
    }
}
