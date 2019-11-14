<?php

namespace App\Console\Commands\Elementa;

use DB;
use Queue;
use Goutte\Client;
use App\Models\Product;
use App\Jobs\ProductImportJob;
use Illuminate\Console\Command;

class SyncAllProductsFromAllCategoriesCommand extends Command
{
    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    private $crawler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elementa:sync-all-products-from-all-categories {--category-name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all products from all categories';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Fetching all category links');
        $categoryLinks = $this->getAllCategoryLinks();
        // dd($categoryLinks);
        $this->line('Starting product links fetch');

        foreach ($categoryLinks as $categoryName => $categoryLink) {
            $this->line('-----------------------------------------');
            $this->line("Category: {$categoryName}");

            if ($this->hasOption('category-name')) {
                // import only passed category
                if (strtolower($this->option('category-name')) !== strtolower($categoryName)) {
                    continue;
                }
            }

            // get product links from category url
            $this->line('Fetching all product links');
            [$productLinks, $categoryId] = $this->getAllProductLinksFromCategory($categoryLink, $categoryName);

            if ($productLinks->count() === 0) {
                $this->comment("Empty category {$categoryName} category, skipping");
                continue;
            }

            // queue product import
            $allFoundLinks = $productLinks->count();

            $productLinks = $productLinks->transform(function ($link) {
                return 'https://elementa.rs' . $link;
            })->reject(function ($link) {
                return Product::where('url', $link)->exists();
            });

            $jobs = $productLinks->map(function ($url) use ($categoryId) {
                return new ProductImportJob($url, $categoryId);
            })->toArray();

            Queue::bulk($jobs, null, ProductImportJob::QUEUE_NAME);

            $jobsCount = count($jobs);
            $alreadyExisted = $allFoundLinks - $jobsCount;
            $this->info("Dispatched {$jobsCount} jobs for '{$categoryName}' category, while {$alreadyExisted} were ignored.");
        }
    }

    /**
     * @param string         $url
     * @param \Goutte\Client $client
     *
     * @return array
     */
    private function getProductLinksFromUrl(string $url, Client $client): array
    {
        $this->crawler = $client->request('GET', $url);

        $this->crawler->filter('.products a.img-product')->each(function ($node) use (&$links) {
            $links[] = $node->attr('href');
        });

        return $links ?? [];
    }

    /**
     * @return array
     */
    private function getAllCategoryLinks(): array
    {
        $categoryLinks = [];
        $client        = new Client();

        $this->crawler = $client->request('GET', 'https://www.elementa.rs/mapa-sajta');

        $this->crawler->filter('ul#sitemap > li')->each(function ($node) use (&$categoryLinks) {
            $node->filter('ul > li')->each(function ($li) use (&$categoryLinks) {
                $li->filter('ul > li > a')->each(function ($li2) use (&$categoryLinks) {
                    $categoryLinks[trim($li2->text())] = 'http://elementa.rs/' . trim($li2->attr('href')) . '/sort/name/page/1/kolicina/12?filters=[]&spec=[]&lager=na-stanju';
                });
            });
        });

        return $categoryLinks;
    }

    /**
     * @param $categoryLink
     * @param $categoryName
     *
     * @return array
     */
    private function getAllProductLinksFromCategory($categoryLink, $categoryName): array
    {
        $productLinks = collect([]);
        $client       = new Client();
        $url          = $categoryLink;
        $categoryId   = DB::connection('shop')->table('category_description')->where('name', $categoryName)->first()->category_id;

        do {
            $productLinks = $productLinks->merge(
                $this->getProductLinksFromUrl($url, $client)
            );

            $nextLinkExists = $this->crawler->filter('.pager-right a.next')->count();

            if ($nextLinkExists) {
                $url = $this->crawler->filter('.pager-right a.next')->attr('href');
            }
        } while ($nextLinkExists);

        return [$productLinks, $categoryId];
    }
}
