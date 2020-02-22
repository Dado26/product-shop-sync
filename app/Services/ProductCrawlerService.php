<?php

namespace App\Services;

use App\Helpers\StringHelper;
use Exception;
use Illuminate\Support\Str;
use Throwable;
use Goutte\Client;
use App\Models\Site;
use App\Models\SyncRules;
use App\Helpers\SiteUrlParser;
use App\Helpers\PriceExtractor;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\BrowserKit\CookieJar;

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
     * @param  string  $url
     * @param  array  $rules
     *
     * @throws \Exception
     */
    public function handle(string $url, array $rules = []): void
    {
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

        // initial request
        $this->crawler = $this->makeRequest($url);

        if ($this->needsAuthCheck() && !$this->isAuthenticated()) {
            // make cookie expired
            $this->site->session->updated(['expires_at' => now()->subDay()]);
            $this->site->refresh();

            // make new request with fresh cookie
            $this->crawler = $this->makeRequest($url);
        }
    }

    /**
     * Make main request to product url
     *
     * @param  string  $url
     *
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function makeRequest($url)
    {
        // get cookie if needed
        $cookie = LoginCrawlerService::getCookie($this->site);

        $cookieJar = new CookieJar();

        if ($cookie !== null) {
            $cookie    = new Cookie($this->site->session_name, $cookie, $this->site->session->expires_at->timestamp);
            $cookieJar->set($cookie);
        }

        // fetch product url
        $client = new Client([], null, $cookieJar);

        return $client->request('GET', $url);
    }

    public function isAuthenticated()
    {
        $rule = $this->site->auth_element_check;

        $auth = $this->crawler->filter($rule)->count();

        return $auth > 0;
    }

    protected function needsAuthCheck()
    {
        return !empty($this->site->auth_element_check);
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

        if (empty($rule)) {
            return '';
        }

        $description = $this->crawler->filter($rule)->html();

        $description = strip_tags($description, '<strong><b><i><p><u><div>');

        return trim($description);
    }

    /**
     * @return string
     */
    public function getSpecifications(): ?string
    {
        if (!$rule = $this->rules->specifications) {
            return null;
        }

        $specifications = $this->crawler->filter($rule)->html();

        $specifications = strip_tags($specifications, ['p', 'tr', 'td', 'tbody', 'b', 'strong', 'i', 'th']);

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
        if (!$rule = $this->rules->in_stock_value) {
            return false;
        }

        try {
            $stockText         = mb_strtolower($this->getInStockValue());
            $expectedStockText = mb_strtolower($rule);
        } catch (Throwable $e) {
            logger()->emergency('Failed to get stock for product', [
                'exception' => $e->getMessage(),
                'url'       => $this->url,
            ]);

            return true;
        }

        $stockText = StringHelper::keepLettersAndNumbers($stockText);
        $expectedStockText = StringHelper::keepLettersAndNumbers($expectedStockText);

        return Str::contains($stockText, $expectedStockText);
    }

    /**
     * @return string
     */
    public function getInStockValue(): ?string
    {
        if (!$rule = $this->rules->in_stock) {
            return null;
        }

        $value = $this->crawler->filter($rule)->text();

        return trim($value);
    }

    /**
     * @return string
     */
    public function getSku(): ?string
    {
        if (!$rule = $this->rules->sku) {
            return null;
        }

        $value = $this->crawler->filter($rule)->text();

        if (!empty($this->rules->remove_string_from_sku)) {
            $value = str_replace($this->rules->remove_string_from_sku, '', $value);
        }

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
            return ['variant'];
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

        $parts = explode('|', $rule);
        $rule = $parts[0];
        $attribute = $parts[1] ?? null;

        $images = $this->crawler->filter($rule)->each(function ($node) use ($attribute) {
            if ($attribute) {
                $imageUrl = $node->attr($attribute);
            }
            else if ($value = $node->attr('href')) {
                $imageUrl = $value;
            }
            else if ($value = $node->attr('src')) {
                $imageUrl = $value;
            }

            if (!Str::contains($imageUrl, 'http')) {
                if ($this->site) {
                    $siteUrl = $this->site->url;
                } else {
                    $requestUrl = request('url');
                    $parsedUrl = parse_url($requestUrl);

                    $siteUrl = 'https://' . $parsedUrl['host'];
                }

                if (Str::startsWith($imageUrl, '/')) {
                    $imageUrl = $siteUrl . $imageUrl;
                } else {
                    $imageUrl = $siteUrl . '/' . $imageUrl;
                }
            }

            return $imageUrl;
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
