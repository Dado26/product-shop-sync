<?php

namespace App\Services;

use App\Models\Site;
use App\Models\SyncRules;
use InvalidArgumentException;
use Goutte\Client;
use App\Models\Product;
use Exception;

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

        
        $domain = parse_url($url);

        $domain = $domain['host'];

         
        $this->site = Site::where('url', 'LIKE', "%$domain%")->first();

        $this->url = $url;

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

        return trim($title);
    }

    /**
     * @return String
     */
    public function getDescription(): String
    {
        $rule = $this->rules->description;

        $description = $this->crawler->filter($rule)->text();

        return trim($description);
    }

    /**
     * @return String
     */
    public function getSpecifications(): ?String
    {
        $rule = $this->rules->specifications;

        if(empty($rule)) return null;

        $specifications = $this->crawler->filter($rule)->html();

        return "<table>".trim($specifications)."</table>";
    }

    /**
     * @return String
     */
    public function getUrl(): String
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function getInStock(): Bool
    {
        $rule = $this->rules->in_stock;

        try {
            $stockText = strtolower($this->crawler->filter($rule)->text());
            $expectedStockText = strtolower($this->rules->in_stock_value);
        } catch (Exception $e) {
            logger()->emergency('Failed to get stock for product', [
                'exception' => $e->getMessage(),
                'site'      => $this->site->id,
                'url'       => $this->url,
            ]);

            return true;
        }

        return trim($stockText) == $expectedStockText;
    }

    /**
     * @return array
     */
    public function getVariants(): array
    {
        $rule = $this->rules->variants;

        $variants = $this->crawler->filter($rule)->each(function ($node) {
           return trim($node->text());
        });

        return $variants;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        $rule = $this->rules->images;
        //dd($images = $this->crawler->filter($rule));
        $images = $this->crawler->filter($rule)->each(function ($node) {
          return $node->attr('src');         
        }); 



        return $images;
    }
}
