<?php

namespace App\Jobs;

use App\Services\ProductCrawlerService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProductImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

        // get stuff

        // create product, variants, images
    }
}
