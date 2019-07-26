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
    public $timeout = 40;

    /**
     * @var \App\Services\ProductCrawlerService
     */
    private $crawler;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
        $this->crawler = new ProductCrawlerService();

        $this->onQueue(self::QUEUE_NAME);
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

        try {
            $this->updateProduct();
            $this->syncVariants();
            TransferUpdateProductJob::dispatch($this->product);
        } catch (InvalidArgumentException $e) {
            $this->product->update(['status' => Product::STATUS_UNAVAILABLE]);

            ShopProduct::where('product_id', $this->product->shop_product_id)->update([
                'status' => 0,
            ]);

            logger()->notice('Product not found, maybe it was removed', [
                'id'        => $this->product->id,
                'url'       => $this->product->url,
                'newStatus' => Product::STATUS_UNAVAILABLE,
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
            'status'         => Product::STATUS_AVAILABLE,
            'synced_at'      => now(),
        ]);

        // update variants
        $oldVariant = Variant::where('product_id', $this->product->id)->get()->pluck('name')->toArray();

        $newVariant = $this->crawler->getVariants();

        $results = ChangeDetectorService::getIntersection($oldVariant, $newVariant);

        $percentagePrice   = $this->product->site->price_modification;

        foreach ($results as $result) {
            $price             = $this->crawler->getPrice();
            $priceModified     = PriceCalculator::modifyByPercent($price, $percentagePrice);
            $this->product->variants()->where('name', $result)->update([
                'price' => $priceModified,
            ]);
        }

        // create new missing variants
        $results = ChangeDetectorService::getArrayWithoutItemsFromFirstArray($oldVariant, $newVariant);

        foreach ($results as $result) {
            $price             = $this->crawler->getPrice();
            $priceModified     = PriceCalculator::modifyByPercent($price, $percentagePrice);
            $this->product->variants()->create([
                'name'  => $result,
                'price' => $priceModified,
            ]);
        }

        // delete removed variants
        $results = ChangeDetectorService::getArrayWithoutItemsFromSecondArray($oldVariant, $newVariant);

        $this->product->variants()->whereIn('name', $results)->delete();
    }

    /**
     * The job failed to process.
     *
     * @param $exception
     *
     * @return void
     */
    public function failed(Throwable $exception)
    {
        //
    }
}
