<?php

namespace App\Jobs;

use Throwable;
use App\Models\Product;
use App\Models\Variant;
use App\Models\ShopProduct;
use Illuminate\Bus\Queueable;
use InvalidArgumentException;
use App\Helpers\PriceCalculator;
use Illuminate\Queue\SerializesModels;
use App\Services\ChangeDetectorService;
use App\Services\ProductCrawlerService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Queue on which we are importing products
     */
    public const QUEUE_NAME = 'products-sync';

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * @var \App\Models\Product
     */
    public $product;

    /**
     * @var int
     */
    public $tries = 2;

    /**
     * @var int
     */
    public $timeout = 60;

    /**
     * @var \App\Services\ProductCrawlerService
     */
    private $crawler;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\Product  $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->crawler = new ProductCrawlerService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->crawler->handle($this->product->url);
        } catch (ModelNotFoundException $e) {
            logger()->warning('Site was not found in our database', ['productUrl' => $this->product->url]);

            $this->fail();
            return;
        }

        // check if product is in stock
        if (!$this->crawler->getInStock()) {
            $this->product->makeProductUnavailable($this->product->shop_product_id);
            return;
        }

        try {
            $this->updateProduct();

            TransferUpdateProductJob::dispatch($this->product)->onQueue(TransferUpdateProductJob::QUEUE_NAME);
        } catch (InvalidArgumentException $e) {
            $this->product->update(['status' => Product::STATUS_DELETED]);

            logger()->notice('Product not found on the source store, maybe it was removed', [
                'id'        => $this->product->id,
                'url'       => $this->product->url,
                'newStatus' => Product::STATUS_DELETED,
                'exception' => $e->getMessage(),
            ]);

            $this->delete();
        } catch (Throwable $e) {
            logger()->error('Failed to sync product', [
                'message'   => $e->getMessage(),
                'exception' => "{$e->getFile()}:{$e->getLine()}",
            ]);

            $this->delay(now()->addHour());
        }
    }

    private function updateProduct(): void
    {
        $this->product->update([
            'site_id'        => $this->crawler->getSite()->id,
            'title'          => $this->crawler->getTitle(),
            'description'    => $this->crawler->getDescription(),
            'url'            => $this->crawler->getUrl(),
            'specifications' => $this->crawler->getSpecifications(),
            'sku'            => $this->crawler->getSku(),
            'synced_at'      => now(),
        ]);

        $this->product->makeProductAvailable($this->product->shop_product_id);

        // update variants
        $oldVariants = Variant::where('product_id', $this->product->id)->get()->pluck('name')->toArray();

        $newVariants = $this->crawler->getVariants();

        $results = ChangeDetectorService::getIntersection($oldVariants, $newVariants);

        // update existing variants
        foreach ($results as $result) {
            $price = $this->crawler->getPrice();

            $this->product->variants()->where('name', $result)->update([
                'price' => PriceCalculator::modifyByPercent(
                    $price,
                    $this->product->site->price_modification,
                    $this->product->site->tax_percent
                ),
            ]);
        }

        // create new missing variants
        $results = ChangeDetectorService::getArrayWithoutItemsFromFirstArray($oldVariants, $newVariants);

        foreach ($results as $result) {
            $price = $this->crawler->getPrice();

            $this->product->variants()->create([
                'name'  => $result,
                'price' => PriceCalculator::modifyByPercent(
                    $price,
                    $this->product->site->price_modification,
                    $this->product->site->tax_percent
                ),
            ]);
        }

        // delete removed variants
        $results = ChangeDetectorService::getArrayWithoutItemsFromSecondArray($oldVariants, $newVariants);

        $this->product->variants()->whereIn('name', $results)->delete();
    }

    /**
     * The job failed to process.
     *
     * @param  $e
     *
     * @return void
     */
    public function failed($e)
    {
        // this will be called only when the last attempt fails
        logger()->warning('Failed to sync product', [
            'id'        => $this->product->id,
            'title'     => $this->product->title,
            'url'       => $this->product->url,
            'exception' => $e ? $e->getMessage() : 'Unknown',
        ]);
    }
}
