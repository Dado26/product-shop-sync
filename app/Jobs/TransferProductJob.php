<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ShopOption;
use App\Models\ShopProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use App\Models\ShopProductDescription;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TransferProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const QUEUE_NAME = 'transfer-product';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $product;

    public $categoryId;

    public function __construct(Product $product, $categoryId)
    {
        $this->product    = $product;

        $this->categoryId = $categoryId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $product        = $this->product;
        $price          = $product->variants->min('price');

        $ShopProduct =  ShopProduct::create([
            'model'           => $product->title,
            'price'           => $price,
            'location'        => $product->url,
            'status'          => ($product->status == 'available') ? 1 : 0,
            'date_available'  => now(),
            'image'           => $product->productImages()->first()->url,
            'sku'             => '',
            'upc'             => '',
            'ean'             => '',
            'jan'             => '',
            'isbn'            => '',
            'mpn'             => '',
            'stock_status_id' => 1,
            'manufacturer_id' => 0,
            'shipping'        => 1,
            'points'          => 0,
            'tax_class_id'    => 0,
            'weight'          => 0.00000000,
            'weight_class_id' => 1,
            'length_class_id' => 1,
            'height'          => 0.00000000,
            'width'           => 0.00000000,
            'length'          => 0.00000000,
            'subtract'        => 1,
            'minimum'         => 1,
            'quantity'        => 1,
            'sort_order'      => 1,
            'viewed'          => 0,
            'date_added'      => now(),
            'date_modified'   => now(),
        ]);

        $product->update(
            [
                'shop_product_id' => $ShopProduct->product_id,
            ]
            );

        $ShopProduct->categories()->attach($this->categoryId);

        ShopProductDescription::create(
            [
                'description'      => $product->description,
                'name'             => $product->title,
                'product_id'       => $ShopProduct->product_id,
                'language_id'      => 2,
                'tag'              => '',
                'meta_title'       => $product->title,
                'meta_description' => '',
                'meta_keyword'     => '',
            ]
              );

        $shopOption = ShopOption::create(
            [
                'type'       => 'select',
                'sort_order' => 0,
            ]
           );
        // dump($shopOption->toArray());

        DB::connection('shop')->table('option_description')->insert([
            'option_id'   => $shopOption->option_id,
            'language_id' => 2,
            'name'        => 'Choose variant',
        ]);

        $product_option =  DB::connection('shop')->table('product_option')->insertGetID([
            'product_id' => $ShopProduct->product_id,
            'option_id'  => $shopOption->option_id,
            'value'      => '',
            'required'   => 1,
        ]);

        foreach ($product->variants as $variant) {
            $variantSame = DB::connection('shop')->table('option_value_description')->where('name', $variant->name)->first();

            if (!is_null($variantSame) && $variantSame->name !== $variant->name) {
                $option_value =  DB::connection('shop')->table('option_value')->insertGetId([
                    'option_id'  => $shopOption->option_id,
                    'image'      => '',
                    'sort_order' => 0,
                ]);

                //$option_value = DB::connection('shop')->table('option_value')->where('option_id', $shopOption->option_id)->first();

                DB::connection('shop')->table('option_value_description')->insert([
                    'option_value_id' => $option_value,
                    'language_id'     => 2,
                    'option_id'       => $shopOption->option_id,
                    'name'            => $variant->name,
                ]);
            } else {
                $option_value = $variantSame->option_value_id;
            }

            DB::connection('shop')->table('product_option_value')->insert([
                'product_option_id' => $product_option,
                'product_id'        => $ShopProduct->product_id,
                'option_id'         => $shopOption->option_id,
                'option_value_id'   => $option_value,
                'quantity'          => 100000,
                'subtract'          => 1,
                'price'             => $variant->price - $price,
                'price_prefix'      => '+',
                'points_prefix'     => '+',
                'points'            => 0,
                'weight'            => 0.00000000,
                'weight_prefix'     => '+',
            ]);
        }

        foreach ($product->productImages as $image) {
            DB::connection('shop')->table('product_image')->insert([
                'product_id' => $ShopProduct->product_id,
                'image'      => $image->url,
                'sort_order' => 0,
            ]);
        }
        DB::connection('shop')->table('product_to_store')->insert([
            'product_id' => $ShopProduct->product_id,
        ]);
    }
}
