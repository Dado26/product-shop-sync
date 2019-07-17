<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ShopProduct;
use Illuminate\Bus\Queueable;
use App\Models\ShopProductDescription;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TransferProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $price          = $product->variants->average('price');

        $ShopProduct =  ShopProduct::create([
            'model'           => $product->title,
            'price'           => $price,
            'location'        => $product->url,
            'status'          => ($product->status == 'available') ? 1 : 0,
            'date_available'  => now(),
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
    }
}
