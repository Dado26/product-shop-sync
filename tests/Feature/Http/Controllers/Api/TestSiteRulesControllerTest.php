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

        $response = $this->getJson('api/sites/test-rules?' . http_build_query($params));

        $response->assertJson([
            'title'         => 'Lampa za insekte',
            'description'   => 'Napravljena specijalno za uništavanje letećih štetnih insekata.',
            'specification' => "<table><tr><td>Brend</td>\n                                        <td>MITEA</td>\n                                    </tr><tr><td>Namena</td>\n                                        <td>Za insekte</td>\n                                    </tr></table>",
            'price'         => '1599.00',
            'in_stock_value'=> true,
            'images'        => [
                'http://www.elementa.rs/images/products/57562/original/1.jpg',
                'http://www.elementa.rs/images/products/57562/original/2.jpg',
                'http://www.elementa.rs/images/products/57562/original/3.jpg',
            ],
            'variants'=> [
                'Blue',
                'White',
                'Black',
            ],
        ]);
    }

    public function test_sites_rules_when_there_are_invalid_rules()
    {
        $params = [
            'url'   => 'http://product-sync/test/product',
            'rules' => [
                'title'          => '#invalid', // INVALID
                'description'    => '.invalid-description', // INVALID
                'specifications' => '#invalid-specs', // IINVALID
                'price'          => '.product-price',
                'in_stock'       => '.product-stock',
                'in_stock_value' => 'In stock',
                'price_decimals' => '2',
                'images'         => '.product-images > img',
                'variants'       => '.invalid', // INVALID
            ],
        ];

        $response = $this->getJson('api/sites/test-rules?' . http_build_query($params));

        $response->assertJson([
            'title'         => null,
            'description'   => null,
            'specification' => null,
            'price'         => '1599.00',
            'in_stock_value'=> true,
            'images'        => [
                'http://www.elementa.rs/images/products/57562/original/1.jpg',
                'http://www.elementa.rs/images/products/57562/original/2.jpg',
                'http://www.elementa.rs/images/products/57562/original/3.jpg',
            ],
            'variants'=> null,
        ]);
    }
}
