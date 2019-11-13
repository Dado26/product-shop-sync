<?php

namespace App\Console\Commands\Elementa;

use DB;
use Goutte\Client;
use Illuminate\Console\Command;

class SyncCategoriesCommand extends Command
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
    protected $signature = 'elementa:sync-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all categories from elementa.rs';

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
        $categories = $this->fetchAllCategories();

        foreach ($categories as $category => $subCategories) {
            $categoryId = $this->firstOrCreateCategory($category, 0);
            $this->addCategoryPath($categoryId, $categoryId, 0);

            foreach ($subCategories as $subCategory => $subSubCategories) {
                $subCategoryId = $this->firstOrCreateCategory($subCategory, $categoryId);
                $this->addCategoryPath($subCategoryId, $categoryId, 0);
                $this->addCategoryPath($subCategoryId, $subCategoryId, 1);

                foreach ($subSubCategories as $subSubSubCategory) {
                    $subSubCategoryId = $this->firstOrCreateCategory($subSubSubCategory, $subCategoryId);

                    $this->addCategoryPath($subSubCategoryId, $categoryId, 0);
                    $this->addCategoryPath($subSubCategoryId, $subCategoryId, 1);
                    $this->addCategoryPath($subSubCategoryId, $subSubCategoryId, 2);

                    $this->info($category.' => '.$subCategory.' => '.$subSubSubCategory);
                }
            }
        }
        DB::connection('shop')->statement("TRUNCATE `category_to_store`");
        DB::connection('shop')->statement("INSERT INTO `category_to_store`(`category_id`, `store_id`) (SELECT category.category_id, category.sort_order FROM category)");
        $this->line("Updated 'category_to_store' table");
        DB::connection('shop')->statement("TRUNCATE `category_to_layout`");
        DB::connection('shop')->statement("INSERT INTO `category_to_layout`(`category_id`, `store_id`, `layout_id`) (SELECT category.category_id, category.sort_order, category.sort_order FROM category)");
        $this->line("Updated 'category_to_layout' table");
        $this->info('Finished!');
    }

    /**
     * @return array
     */
    private function fetchAllCategories(): array
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

        return $categories;
    }

    /**
     * @param $category
     * @param $parentId
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|int|mixed|object|null
     */
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

    /**
     * @param $parentId
     * @param $categoryId
     * @param $level
     */
    private function addCategoryPath($parentId, $categoryId, $level): void
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
