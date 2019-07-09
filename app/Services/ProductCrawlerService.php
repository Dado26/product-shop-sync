<?php

namespace App\Services;

use App\Models\Site;
use App\Models\SyncRules;
use InvalidArgumentException;

class ProductCrawlerService
{
    /**
     * @var Site
     */
    private $site;

    /**
     * @var SyncRules
     */
    private $rules;

    /**
     * @param  string  $url
     *
     * @return array
     */
    public function handle(string $url): array
    {
        if (empty($url)) {
            throw new InvalidArgumentException('Product URL cannot be empty');
        }

        // get site from product url

        // fetch product url

        // get sync rules from site
    }

    /**
     * @return String
     */
    public function getTitle(): String
    {
        //
    }

    /**
     * @return String
     */
    public function getDescription(): String
    {
        //
    }

    /**
     * @return String
     */
    public function getSpecifications(): String
    {
        //
    }

    /**
     * @return String
     */
    public function getUrl(): String
    {
        //
    }

    /**
     * @return bool
     */
    public function getInStock(): Bool
    {
        //
    }

    /**
     * @return \App\Services\Array
     */
    public function getVariants(): Array
    {
        //
    }

    /**
     * @return \App\Services\Array
     */
    public function getImages(): Array
    {
        //
    }
}
