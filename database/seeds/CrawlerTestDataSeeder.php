<?php

use App\Models\Site;
use Illuminate\Database\Seeder;

class CrawlerTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $site = Site::create([
            'name'  => 'ProductSync',
            'url'   => 'http://product-sync/',
            'email' => 'test@mail.com',
        ]);

        $site->syncRules()->create([
            'title'          => '#product-title',
            'description'    => '.product-description',
            'price'          => '.product-price',
            'in_stock'       => '.product-stock',
            'in_stock_value' => 'In stock',
            'images'         => '.product-images > img',
            'variants'       => '.variants > .color',
            'specifications' => '#product-specs',
        ]);
    }
}
