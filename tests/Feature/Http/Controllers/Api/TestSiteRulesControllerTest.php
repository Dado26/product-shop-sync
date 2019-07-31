<?php

namespace Tests\Feature\Http\Controllers\Api;

use Tests\TestCase;

class TestSiteRulesControllerTest extends TestCase
{
    public function test_sites_rules()
    {
        $params = [
            'url'   => 'http://product-sync/test/product',
            'rules' => [
                'title'          => '#product-title',
                'description'    => '.product-description',
                'specifications' => '#product-specs',
                'price'          => '.product-price',
                'in_stock'       => '.product-stock',
                'in_stock_value' => 'In stock',
                'price_decimals' => '2',
                'images'         => '.product-images > img',
                'variants'       => '.variants > .color',
            ],
        ];

        $response = $this->postJson('api/sites/test-rules', $params);

        $response->assertJson([
            'title'          => 'Lampa za insekte',
            'description'    => 'Napravljena specijalno za uništavanje letećih štetnih insekata.',
            'price'          => '1899.00',
            'in_stock_value' => true,
            'images'         => [
                'http://www.elementa.rs/images/products/57562/original/1.jpg',
                'http://www.elementa.rs/images/products/57562/original/2.jpg',
                'http://www.elementa.rs/images/products/57562/original/3.jpg',
            ],
            'variants'       => [
                'Blue',
                'White',
                'Black',
            ],
        ]);

        $this->assertNotNull($response->decodeResponseJson()['specifications']);
    }

    public function test_sites_rules_when_there_all_are_invalid()
    {
        $params = [
            'url'   => 'http://product-sync/test/product',
            'rules' => [
                'title'          => '#product-title-invalid', // INVALID
                'description'    => '.invalid-description', // INVALID
                'specifications' => '#invalid-specs', // IINVALID
                'price'          => '.product-price-invalid', // INVALID
                'in_stock'       => '.product-stock-invalid', // INVALID
                'price_decimals' => '2', // INVALID
                'images'         => '.product-images > img-invalid', // INVALID
                'variants'       => '.invalid', // INVALID
            ],
        ];

        $response = $this->postJson('api/sites/test-rules', $params);

        $response->assertJson([
            'title'          => null,
            'description'    => null,
            'specifications' => null,
            'price'          => null,
            'in_stock_value' => null,
            'images'         => null,
            'variants'       => null,
        ]);
    }
}
