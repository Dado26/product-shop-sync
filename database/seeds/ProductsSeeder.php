<?php

use App\Models\Site;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Site::all()->each(function ($site) {
            factory(Product::class, rand(1, 6))->create(['site_id' => $site->id]);
        });
    }
}
