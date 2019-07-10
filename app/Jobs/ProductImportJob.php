<?php

namespace App\Jobs;

use App\Services\ProductCrawlerService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\ProductImage;
use App\Models\Variant;
use App\Models\Product;

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

        $crawler->handle($this->url);

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
            ProductImage::create(
                ['url' => $image,
                'product_id' => $product->id,
                ]                    
            );
        }      
    }
}
