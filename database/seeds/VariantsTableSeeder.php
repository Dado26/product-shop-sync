<?php

use Illuminate\Database\Seeder;
use App\Models\Variant;
use App\Models\Product;

class VariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::all()->each(function ($product) {
            factory(Variant::class, rand(1, 4))->create(['product_id' => $product->id]);
        });
    }
}
