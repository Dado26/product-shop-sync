<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ShopProduct;
use DB;
use Illuminate\Bus\Queueable;
use App\Models\ShopProductDescription;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Throwable;

class TransferUpdateProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const QUEUE_NAME = 'transfer-update-product';

    /**
     * @var int
     */
    public $tries = 3;

    /**
     * @var int
     */
    public $timeout = 60;

    /**
     * @var \App\Models\Product
     */
    public $product;

    /**
     * TransferUpdateProductJob constructor.
     *
     * @param  \App\Models\Product  $product
     */
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
        DB::beginTransaction();

        $shopProduct = ShopProduct::where('product_id', $this->product->shop_product_id)->first();

        if (!$shopProduct) {
            logger()->notice('Product not found in store, maybe it was removed', ['id' => $this->product->id]);
            $this->delete();
            return;
        }

        if ($shopProduct->status == 0 || $shopProduct == null) {
            $this->product->update([
                'status' => ($shopProduct->status == 0) ? Product::STATUS_ARCHIVED : Product::STATUS_DELETED,
            ]);
            return;
        }

        try {
            $shopProduct->update([
                'model'           => $this->product->title,
                'price'           => $this->product->variants->min('price'),
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
            ]);

            ShopProductDescription::where('product_id', $shopProduct->product_id)->update([
                'description'      => $this->product->description,
                'name'             => $this->product->title,
                'product_id'       => $shopProduct->product_id,
                'language_id'      => 2,
                'tag'              => '',
                'meta_title'       => $this->product->title,
                'meta_description' => '',
                'meta_keyword'     => '',
            ]);

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * The job failed to process.
     *
     * @param  Throwable  $e
     *
     * @return void
     */
    public function failed(Throwable $e)
    {
        logger()->warning('Failed to update shop product', [
            'id'        => $this->product->id,
            'title'     => $this->product->title,
            'url'       => $this->product->url,
            'exception' => $e->getMessage(),
        ]);
    }
}
