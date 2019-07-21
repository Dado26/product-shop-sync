<?php

namespace App\Services;

use App\Helpers\PriceExtractor;
use App\Helpers\SiteUrlParser;
use App\Models\Site;
use App\Models\SyncRules;
use Goutte\Client;
use Exception;
use Throwable;

class ProductCrawlerService
{
    /**
     * @var Site
     */
    private $site;

    /**
     * @var String
     */
    private $url;

    /**
     * @var SyncRules
     */
    private $rules;

    /**
     * @var Client
     */
    private $crawler;

    /**
     * @param string $url
     */
    public function handle(string $url, array $rules = []): void
    {
        $client = new Client();

        if (empty($url)) {
            throw new Exception('Product URL cannot be empty');
        }

        $this->url = $url;

        if (empty($rules)) {
            $this->site  = SiteUrlParser::getSite($url);
            $this->rules = $this->site->syncRules;
        } else {
            $this->rules = (object) $rules;
        }

        // fetch product url
        $this->crawler = $client->request('GET', $url);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        $rule = $this->rules->title;

        $title = $this->crawler->filter($rule)->text();

        return trim($title);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        $rule = $this->rules->description;

        $description = $this->crawler->filter($rule)->html();

        return trim($description);
    }

    /**
     * @return string
     */
    public function getSpecifications(): ?string
    {
        $rule = $this->rules->specifications;

        if (empty($rule)) {
            return null;
        }

        $specifications = $this->crawler->filter($rule)->html();

        return '<table>' . trim($specifications) . '</table>';
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function getInStock(): bool
    {
        try {
            $stockText         = strtolower($this->getInStockValue());
            $expectedStockText = strtolower($this->rules->in_stock_value);
        } catch (Throwable $e) {
            logger()->emergency('Failed to get stock for product', [
                'exception' => $e->getMessage(),
                'url'       => $this->url,
            ]);

            return true;
        }

        return trim($stockText) == $expectedStockText;
    }

    /**
     * @return string
     */
    public function getInStockValue(): string
    {
        $rule = $this->rules->in_stock;

        $value = $this->crawler->filter($rule)->text();

        return trim($value);
    }

    /**
     * @return array
     */
    public function getVariants(): array
    {
        $rule = $this->rules->variants;

        if (empty($rule)) {
            // when there is no rule for variants
            // we want to create one without name
            return [null];
        }

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

        $images = $this->crawler->filter($rule)->each(function ($node) {
            return $node->attr('src');
        });

        return $images;
    }

    /**
     * @return Site
     */
    public function getSite(): Site
    {
        return $this->site;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        $rule = $this->rules->price;

        $price    = $this->crawler->filter($rule)->html();
        $decimals = $this->rules->price_decimals;

        return PriceExtractor::handle($price, $decimals);
    }
}
