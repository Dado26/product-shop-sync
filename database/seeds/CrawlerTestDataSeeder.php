<?php

use App\Models\Site;
use App\Models\User;
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
            'name'               => 'ProductSync',
            'url'                => 'http://product-sync/',
            'email'              => 'test@mail.com',
            'user_id'            => User::first()->id,
            'price_modification' => rand(-10, 10),
        ]);

        $site->syncRules()->create([
            'title'          => '#product-title',
            'description'    => '.product-description',
            'price'          => '.product-price',
            'price_decimals' => 2,
            'in_stock'       => '.product-stock',
            'in_stock_value' => 'In stock',
            'images'         => '.product-images > img',
            'variants'       => '.variants > .color',
            'specifications' => '#product-specs',
        ]);
    }
}
