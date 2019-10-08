<?php

namespace App\Http\Controllers;

use App\Helpers\SiteUrlParser;
use App\Jobs\ProductImportJob;
use DB;
use Goutte\Client;
use Illuminate\Http\Request;
use Queue;

class UtilitiesController extends Controller
{
    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    private $crawler;


    public function fetchProductLinksFromCategory(Request $request)
    {
        // ELEMENTA
        $links  = collect([]);
        $client = new Client();

        $url = $request->url;

        echo "<form action=''>
            <input name='url' value='{$request->url}' style='width:600px'>
            <input type='submit' value='Submit'/>
        </form>";

        if (empty($url)) {
            exit;
        }

        do {
            echo "[*] ";

            $links = $links->merge(
                $this->getProductLinksFromUrl($url, $client)
            );

            $nextLinkExists = $this->crawler->filter('.pager-right a.next')->count();

            if ($nextLinkExists) {
                $url = $this->crawler->filter('.pager-right a.next')->attr('href');
            }
        } while ($nextLinkExists);

        $links->transform(function ($link) {
            return "https://elementa.rs".$link;
        });

        echo "<hr>
        Products count: {$links->count()}<br>
        <textarea style='width:600px; height:600px'>{$links->implode("
")}</textarea>";
    }

    /**
     * @param  string  $url
     * @param  \Goutte\Client  $client
     *
     * @return array
     */
    private function getProductLinksFromUrl(string $url, Client $client): array
    {
        $this->crawler = $client->request('GET', $url);

        $this->crawler->filter('.products a.img-product')->each(function ($node) use (&$links) {
            $links[] = $node->attr('href');
        });

        return $links;
    }

    public function fetchAllCategories()
    {
        $categories = [];
        $client     = new Client();

        $this->crawler = $client->request('GET', 'https://www.elementa.rs/mapa-sajta');

        $this->crawler->filter('ul#sitemap > li')->each(function ($node) use (&$categories) {
            $subCategory = trim($node->children()->first()->text());

            $node->filter('ul > li')->each(function ($li) use (&$categories, $subCategory) {
                $subSubCategory = trim($li->children()->first()->text());

                $li->filter('ul > li')->each(function ($li2) use (&$categories, $subCategory, $subSubCategory) {
                    $categories[$subCategory][$subSubCategory][] = trim($li2->text());
                });
            });
        });

        //dd($categories);

        $i1 = $i2 = $i3 = 0;

        foreach ($categories as $category => $subCategories) {
            $i1++;
            $categoryId = $this->firstOrCreateCategory($category, 0);
            $this->addCategoryPath($categoryId, $categoryId, 0);

            foreach ($subCategories as $subCategory => $subSubCategories) {
                $i2++;
                $subCategoryId = $this->firstOrCreateCategory($subCategory, $categoryId);
                $this->addCategoryPath($subCategoryId, $categoryId, 0);
                $this->addCategoryPath($subCategoryId, $subCategoryId, 1);

                foreach ($subSubCategories as $subSubSubCategory) {
                    $i3++;
                    $subSubCategoryId = $this->firstOrCreateCategory($subSubSubCategory, $subCategoryId);

                    $this->addCategoryPath($subSubCategoryId, $categoryId, 0);
                    $this->addCategoryPath($subSubCategoryId, $subCategoryId, 1);
                    $this->addCategoryPath($subSubCategoryId, $subSubCategoryId, 2);

                    echo $category.' => '.$subCategory.' => '.$subSubSubCategory.'<br>';

                    //if ($i3 === 1) die;
                }
            }
        }
    }

    public function fetchAllProductsFromCategories()
    {
        set_time_limit(0);
        
        $categoryLinks = [];
        $client     = new Client();

        $this->crawler = $client->request('GET', 'https://www.elementa.rs/mapa-sajta');

        $this->crawler->filter('ul#sitemap > li')->each(function ($node) use (&$categoryLinks) {
            $node->filter('ul > li')->each(function ($li) use (&$categoryLinks) {
                $li->filter('ul > li > a')->each(function ($li2) use (&$categoryLinks) {
                    $categoryLinks[trim($li2->text())] = "http://elementa.rs/" . trim($li2->attr('href')) . "/sort/name/page/1/kolicina/12?filters=[]&spec=[]&lager=na-stanju";
                });
            });
        });

        foreach ($categoryLinks as $categoryName => $categoryLink) {
            // get product links from category url
            $productLinks  = collect([]);
            $client = new Client();
            $url = $categoryLink;
            $categoryId = DB::connection('shop')->table('category_description')->where('name', $categoryName)->first()->category_id;

            do {
                $productLinks = $productLinks->merge(
                    $this->getProductLinksFromUrl($url, $client)
                );

                $nextLinkExists = $this->crawler->filter('.pager-right a.next')->count();

                if ($nextLinkExists) {
                    $url = $this->crawler->filter('.pager-right a.next')->attr('href');
                }
            } while ($nextLinkExists);

            // queue product import
            $jobs = $productLinks->map(function ($url) use ($categoryId) {
                return new ProductImportJob($url, $categoryId);
            })->toArray();

            Queue::bulk($jobs, null, ProductImportJob::QUEUE_NAME);
        }
    }

    private function firstOrCreateCategory($category, $parentId)
    {
        $categoryId = DB::connection('shop')
                        ->table('category_description')
                        ->where('name', $category)
                        ->first();

        if (!$categoryId) {
            $categoryId = DB::connection('shop')->table('category')->insertGetID([
                'parent_id'     => $parentId,
                'status'        => 1,
                'date_added'    => '2019-10-07 21:00:00',
                'date_modified' => '2019-10-07 21:00:00',
            ]);

            DB::connection('shop')->table('category_description')->insertGetID([
                'category_id' => $categoryId,
                'language_id' => 2,
                'name'        => $category,
                'meta_title'  => $category,
            ]);
        }

        return is_object($categoryId) ? $categoryId->category_id : $categoryId;
    }

    private function addCategoryPath($parentId, $categoryId, $level)
    {
        $categoryPath = DB::connection('shop')
                          ->table('category_path')
                          ->where('category_id', $parentId)
                          ->where('path_id', $categoryId)
                          ->exists();

        if (!$categoryPath) {
            DB::connection('shop')->table('category_path')->insert([
                'category_id' => $parentId,
                'path_id'     => $categoryId,
                'level'       => $level,
            ]);
        }
    }
}
