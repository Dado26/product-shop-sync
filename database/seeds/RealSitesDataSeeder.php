<?php

use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Seeder;

class RealSitesDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $site = Site::create([
            'name'    => 'Elementa',
            'url'     => 'https://www.elementa.rs',
            'email'   => 'vstruhar@gmail.com',
            'user_id' => User::first()->id,
        ]);

        $site->syncRules()->create([
            'title'          => 'div.product-details > div.headline > h1',
            'description'    => 'div.product-details-content > div.short-description',
            'price'          => 'div.product-details-content > div.short-description > div.top-box > span',
            'price_decimals' => 2,
            'in_stock'       => 'div.product-details-content > div.short-description > div.bottom-box > p.w50.fr > span:nth-child(3) > span',
            'in_stock_value' => 'Artikal je dostupan!',
            'images'         => '#imageGallery img',
            'variants'       => null,
            'specifications' => '#technical-data > table',
        ]);
    }
}
