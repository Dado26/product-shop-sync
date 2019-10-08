<?php

namespace App\Jobs;

use DB;
use Throwable;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Bus\Queueable;
use InvalidArgumentException;
use PHPUnit\Runner\Exception;
use App\Helpers\SiteUrlParser;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Queue\SerializesModels;
use App\Services\ProductCrawlerService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Helpers\PriceCalculator;

class ProductImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Queue on which we are importing products
     */
    public const QUEUE_NAME = 'products-import';

    /**
     * @var String
     */
    private $url;

    /**
     * @var int
     */
    private $categoryId;

    /**
     * @var \App\Services\ProductCrawlerService
     */
    private $crawler;

    /**
     * @var int
     */
    public $tries = 2;

    /**
     * @var int
     */
    public $timeout = 60;

    /**
     * Create a new job instance.
     *
     * @param  String  $url
     * @param  int  $categoryId
     */
    public function __construct(String $url, int $categoryId)
    {
        $this->url        = $url;
        $this->categoryId = $categoryId;
        $this->crawler    = new ProductCrawlerService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (Product::where('url', $this->url)->exists()) {
            logger()->debug('Product was already imported, skipping', ['url' => $this->url]);
            $this->delete();
            return;
        }

        try {
            $this->crawler->handle($this->url);
        } catch (ModelNotFoundException $e) {
            logger()->warning('Site was not found in our database', ['productUrl' => $this->url]);

            $this->delete();
            return;
        }

        try {
            DB::beginTransaction();

            $product = $this->createProduct();

            $this->createVariants($product);
            $this->createAndUploadImages($product);

            DB::commit();

            TransferProductJob::dispatch($product, $this->categoryId)->onQueue(TransferProductJob::QUEUE_NAME);
        } catch (InvalidArgumentException $e) {
            logger()->warning('Product data not found, please check site rules.', [
                'url'       => $this->url,
                'exception' => $e->getMessage(),
            ]);

            DB::rollBack();
            $this->delete();
        } catch (Throwable $e) {
            logger()->error('Failed to import product from url', [
                'message'   => $e->getMessage(),
                'exception' => "{$e->getFile()}:{$e->getLine()}",
            ]);

            DB::rollBack();
            $this->fail();
        }
    }

    /**
     * @return \App\Models\Product|\Illuminate\Database\Eloquent\Model
     */
    private function createProduct()
    {
        return Product::create([
            'site_id'        => $this->crawler->getSite()->id,
            'title'          => $this->crawler->getTitle(),
            'description'    => $this->crawler->getDescription(),
            'url'            => $this->crawler->getUrl(),
            'specifications' => $this->crawler->getSpecifications(),
            'status'         => Product::STATUS_AVAILABLE,
            'synced_at'      => now(),
        ]);
    }

    /**
     * @return void
     */

    /**
     * @param $product
     */
    private function createVariants($product)
    {
        $site = SiteUrlParser::getSite($this->url);

        foreach ($this->crawler->getVariants() as $variant) {
            $price         = $this->crawler->getPrice();
            $priceModified = PriceCalculator::modifyByPercent($price, $site->price_modification, $site->tax_percent);

            Variant::create([
                'name'       => $variant,
                'price'      => $priceModified,
                'product_id' => $product->id,
            ]);
        }
    }

    /**
     * @param $product
     *
     * @throws \Exception
     */
    private function createAndUploadImages($product): void
    {
        foreach ($this->crawler->getImages() as $imageUrl) {
            $imageUrl = Str::startsWith($imageUrl, '//') ? "https:{$imageUrl}" : $imageUrl;

            $image = ProductImage::create([
                'url'        => null,
                'source'     => $imageUrl,
                'product_id' => $product->id,
            ]);

            try {
                $cloudinaryImage = Cloudder::upload(
                    $imageUrl,
                    "intercool/products/{$product->id}/{$image->id}",
                    ['crop' => 'fit', 'width' => 700, 'height' => 700, 'format' => 'jpg', 'quality' => 'auto:good']
                );

                $result = $cloudinaryImage->getResult();

                $image->update(['url' => $result['secure_url']]);
            } catch (Exception $e) {
                $image->delete();

                logger()->notice('Failed to upload image to cloudinary', [
                    'error'      => $e->getMessage(),
                    'productUrl' => $this->crawler->getUrl(),
                ]);
            }
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
        // this will be called only when the last attempt fails
        logger()->warning('Failed to import product', [
            'url'        => $this->url,
            'categoryId' => $this->categoryId,
            'exception'  => $e->getMessage(),
        ]);
    }
}
