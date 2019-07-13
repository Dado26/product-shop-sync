<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\Variant;
use App\Services\ProductCrawlerService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Services\ChangeDetectorService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use InvalidArgumentException;
use PHPUnit\Runner\Exception;

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
     * @param  \App\Models\Product  $product
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
        $this->crawler->handle($this->product->url);


        try {
            $this->updateProduct();
            $this->syncVariants();
        } catch (InvalidArgumentException $e) {
            logger()->notice('Product not found, maybe it was removed', [
                'productId'  => $this->product->id,
                'productUrl' => $this->product->url,
            ]);

            $this->product->update(['status' => Product::STATUS_UNAVAILABLE]);

            $this->delete();
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
    }

    private function syncVariants(): void
    {
        $oldVariant = Variant::where($this->product->id, 'product_id')->get();

        $newVariant = $this->crawler->getVariants();

        $results = ChangeDetectorService::getIntersection($oldVariant, $newVariant);

        foreach ($results as $result) {
            $this->product->variants()->where('name', $result)->update([
                'price' => $this->crawler->getPrice(),
            ]);
        }

        // create new missing variants
        $results = ChangeDetectorService::getArrayWithoutItemsFromFirstArray($oldVariant, $newVariant);

        foreach ($results as $result) {
            $this->product->variants()->create([
                'name'  => $result,
                'price' => $this->crawler->getPrice(),
            ]);
        }

        // delete removed variants
        $results = ChangeDetectorService::getArrayWithoutItemsFromSecondArray($oldVariant, $newVariant);

        $this->product->variants()->whereIn('name', $results)->delete();
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $e
     *
     * @return void
     */
    public function failed(Exception $e)
    {
        logger()->warning('Failed to sync product', [
            'message'   => $e->getMessage(),
            'exception' => "{$e->getFile()}:{$e->getLine()}",
        ]);

        $this->delay(now()->addHour());
    }
}
