<?php

namespace App\Jobs;

use App\Models\Product;
use App\Services\ProductCrawlerService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Services\ChangeDetectorService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use InvalidArgumentException;

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
     * Create a new job instance.
     *
     * @param  \App\Models\Product  $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;

        $this->onQueue(self::QUEUE_NAME);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $crawler = new ProductCrawlerService();

        try {
            $crawler->handle($this->product->url);
        } catch (InvalidArgumentException $e) {
            logger()->notice('Failed to find required product data, maybe it was removed', ['productUrl' => $this->product->url]);

            $this->product->update(['status' => Product::STATUS_UNAVAILABLE]);

            $this->delete();
        }

        // update product
        $this->product->update([
            'site_id'        => $crawler->getSite()->id,
            'title'          => $crawler->getTitle(),
            'description'    => $crawler->getDescription(),
            'url'            => $crawler->getUrl(),
            'specifications' => $crawler->getSpecifications(),
            'status'         => Product::STATUS_AVAILABLE,
            'synced_at'      => now(),
        ]);


        // update variants
        $oldVariant = Variant::where($this->product->id, 'product_id')->get();

        $newVariant = $crawler->getVariants();

        $results = ChangeDetectorService::getIntersection($oldVariant, $newVariant);

        foreach ($results as $result) {
            $this->product->variants()->where('name', $result)->update([
                'price' => $crawler->getPrice(),
            ]);
        }

        // create new missing variants
        $results = ChangeDetectorService::getArrayWithoutItemsFromFirstArray($oldVariant, $newVariant);

        foreach ($results as $result) {
            $this->product->variants()->create([
                'name'  => $result,
                'price' => $crawler->getPrice(),
            ]);
        }

        // delete removed variants
        $results = ChangeDetectorService::getArrayWithoutItemsFromSecondArray($oldVariant, $newVariant);

        $this->product->variants()->whereIn('name', $results)->delete();
    }
}
