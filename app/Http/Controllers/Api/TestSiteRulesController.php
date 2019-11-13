<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Http\Controllers\Controller;
use App\Services\ProductCrawlerService;
use App\Helpers\PriceCalculator;

class TestSiteRulesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function get(Request $request)
    {
        $crawler = new ProductCrawlerService;

        $params = $request->validate([
            'url'   => 'required|url',
            'rules' => 'required|array',
        ]);

        $crawler->handle($params['url'], $params['rules']);

        $values = [
            'title'          => 'getTitle',
            'description'    => 'getDescription',
            'specifications' => 'getSpecifications',
            'price'          => 'getPrice',
            'in_stock_value' => 'getInStockValue',
            'images'         => 'getImages',
            'variants'       => 'getVariants',
            'sku'            => 'getSku',
        ];

        $results = [];

        foreach ($values as $key => $methodName) {
            try {
                $results[$key] = $crawler->{$methodName}();
            } catch (InvalidArgumentException $e) {
                $results[$key] = null;
            }
        }
        if ($request->price_modification !== null) {
            $modifiedPrice = PriceCalculator::modifyByPercent($results['price'], $request->price_modification, $request->tax_percent);

            $results['price_modification'] = number_format($modifiedPrice, 2, '.', '');
        } else {
            $results['price_modification'] = $results['price'];
        }

        return response()->json($results);
    }
}
