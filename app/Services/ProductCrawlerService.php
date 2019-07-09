<?php

namespace App\Services;

use App\Models\Site;
use App\Models\SyncRules;
use InvalidArgumentException;
use Goutte\Client;
use App\Models\Product;

class ProductCrawlerService
{
    
    /**
     * @var Site
     */
    private $site;

    private $url;

    /**
     * @var SyncRules
     */
    private $rules;

    private $crawler;

    /**
     * @param  string  $url
     */
    public function handle(string $url)
    {
        $client = new Client();

        if (empty($url)) {
            throw new InvalidArgumentException('Product URL cannot be empty');
        }

        // get site from product url
        // http://product-sync/test/product
        // product-sync => Site::where('url', 'LIKE', "%$domain%")->first()
        $domain = 'product-sync';
         
        $this->site = Site::where('url', 'LIKE', "%$domain%")->first();

        $this->$url;



        //$this->product = Product::where('url', 'LIKE', $url)->first();


        // fetch product url
        $this->crawler = $client->request('GET', $url);

        // get sync rules from site
        $this->rules = $this->site->syncRules;
    }

    /**
     * @return String
     */
    public function getTitle(): String
    {
        $rule = $this->rules->title;

        $title = $this->crawler->filter($rule)->text();

        return $title;
    }

    /**
     * @return String
     */
    public function getDescription(): String
    {
        $rule = $this->rules->description;

        $description = $this->crawler->filter($rule)->text();

        return $description;
    }

    /**
     * @return String
     */
    public function getSpecifications(): String
    {
        $rule = $this->rules->specifications;

        $specifications = $this->crawler->filter($rule)->text();

        return $specifications;
    }

    /**
     * @return String
     */
    public function getUrl(): String
    {
        $rule = $this->url;

        $url = $this->crawler->filter($rule)->text();

        return $url;
    }

    /**
     * @return bool
     */
    public function getInStock(): Bool
    {
        //
    }

    /**
     * @return array
     */
    public function getVariants(): array
    {
        
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        //
    }
}
