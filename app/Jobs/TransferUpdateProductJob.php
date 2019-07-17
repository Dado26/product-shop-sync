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

class TransferUpdateProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ShopProduct =  ShopProduct::where('product_id', $this->product->shop_product_id)->first();

        $price       = $this->product->variants->average('price');

        $ShopProduct->update(
            [
                'model'           => $this->product->title,
                'price'           => $price,
                'location'        => $this->product->url,
                'status'          => ($this->product->status == 'available') ? 1 : 0,
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
            ]
        );

        ShopProductDescription::where('product_id', $ShopProduct->product_id)->update(
            [
                'description'      => $this->product->description,
                'name'             => $this->product->title,
                'product_id'       => $ShopProduct->product_id,
                'language_id'      => 2,
                'tag'              => '',
                'meta_title'       => $this->product->title,
                'meta_description' => '',
                'meta_keyword'     => '',
            ]
        );
    }
}
