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
        $product        = $this->product;
        $price          = $product->variants->average('price');

        if ($product->status == 'available') {
            return $status = 1;
        } else {
            return $status = 0;
        }

        $ShopProduct =  ShopProduct::create(
            [
                'model'    => $product->title,
                'image'    => $price,
                'location' => $price->url,
                'status'   => $status,
            ]
        );
        $product->update(
            [
                'shop_product_id' => $ShopProduct->product_id,
            ]
            );

        ShopProductDescription::create(
            [
                'description' => $product->description,
                'name'        => $product->title,
                'product_id'  => $ShopProduct->product_id,
            ]
              );
    }
}
