<?php

namespace App\Jobs\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\ShopCategoryDescription;

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
        if ($this->product->status == 'available') {
            return $status = 1;
        } else {
            return $status = 0;
        }

        $ShopProduct =  ShopProduct::where('product_id', $this->product->shop_product_id)->first();

        $ShopProduct->update(
            [
                'model'       => $this->product->title,
                'image'       => $this->price,
                'location'    => $this->price->url,
                'status'      => $status,
            ]
        );

        ShopCategoryDescription::where('product_id', $ShopProduct->product_id)->update(
            [
                'description' => $this->product->description,
                'name'        => $this->product->title,
            ]
        );
    }
}
