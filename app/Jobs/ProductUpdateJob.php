<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProductUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $product;
    
    public function __construct($product)
    {
        $this->product= $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
   
    public function handle( ){

    $crawler = new ProductCrawlerService();

    try {
        $crawler->handle($this->product->url);
    } catch (InvalidArgumentException $e) {
        $this->fail('Failed to find required data, maybe it was removed');
    }

    {
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
            Variant::update(
                ['name' => $variant,
                'price' => $crawler->getPrice(),
                'product_id' => $product->id,
                ]                    
            );
        }


    }
}
