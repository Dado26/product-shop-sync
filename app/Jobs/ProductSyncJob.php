<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\ProductImage;

class ProductSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Models\Product
     */
    private $product;

    /**
     * Create a new job instance.
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
        $crawler = new ProductCrawlerService();

        try {
            $crawler->handle($this->product->url);
        } catch (InvalidArgumentException $e) {
            $this->product->update([
                'status' => Product::STATUS_UNAVAILABLE,
            ]
            );
            $this->fail('Failed to find required data, maybe it was removed');
        }
    
        
            $this->product->update([
                'site_id' => $crawler->getSite()->id,
                'title' => $crawler->getTitle(),
                'description'=> $crawler->getDescription(),
                'url' => $crawler->getUrl(),
                'category' => $this->category,
                'specifications' => $crawler->getSpecifications(),
                'status' => Product::STATUS_AVAILABLE,
            ]);
    
    
            foreach($crawler->getVariants() as $variant){
                
                Variant::where($this->product->id, 'product_id')->update(
                    ['name' => $variant,
                    'price' => $crawler->getPrice(),
                    'product_id' => $this->product->id,
                    ]                    
                );
            }



            foreach($crawler->getImages() as $image){
                $productImage = ProductImage::where($this->product->id, 'product_id')->update(
                    [
                        'url' => ,
                        'source' => $image,
                        'product_id' => $this->product->id,
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
