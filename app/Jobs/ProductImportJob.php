<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\Variant;
use App\Models\ProductImage;
use Illuminate\Bus\Queueable;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Queue\SerializesModels;
use App\Services\ProductCrawlerService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use PHPUnit\Runner\Exception;

class ProductImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Queue on which we are importing products
     */
    public const QUEUE_NAME = 'import-products';

    /**
     * @var String
     */
    private $url;

    /**
     * @var String
     */
    private $category;

    /**
     * Create a new job instance.
     *
     * @param  String  $url
     * @param  String  $category
     */
    public function __construct(String $url, String $category)
    {
        $this->url = $url;
        $this->category = $category;

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
            $crawler->handle($this->url);
        } catch (InvalidArgumentException $e) {
            $this->fail('Failed to find required data, maybe it was removed');
        }

        // create product, variants, images
       $product = Product::create([
            'site_id' => $crawler->getSite()->id,
            'title' => $crawler->getTitle(),
            'description'=> $crawler->getDescription(),
            'url' => $crawler->getUrl(),
            'category' => $this->category,
            'specifications' => $crawler->getSpecifications(),
            'status' => Product::STATUS_AVAILABLE,
        ]);


        foreach($crawler->getVariants() as $variant){
            Variant::create(
                ['name' => $variant,
                'price' => $crawler->getPrice(),
                'product_id' => $product->id,
                ]                    
            );
        }


        foreach($crawler->getImages() as $image){
            $productImage = ProductImage::create(
                [
                    'url' => null,
                    'source' => $image,
                    'product_id' => $product->id,
                ]                    
            );

            try {
              $cloudinaryImage = Cloudder::upload($image, "intercool/products/{$product->id}/{$productImage->id}");
            }
            catch(Exception $e){
                $productImage->delete();

                logger()->notice('Failed to upload image to cloudinary', ['error' => $e->getMessage()]);
            }
            
            $result = $cloudinaryImage->getResult();

            $productImage->update(['url' => $result['secure_url']]);
        }
    }
}
