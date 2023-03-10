<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(SitesTableSeeder::class);
        $this->call(SyncRulesTableSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(VariantsTableSeeder::class);
        $this->call(ProductImagesTableSeeder::class);
        $this->call(CrawlerTestDataSeeder::class);
        $this->call(RealSitesDataSeeder::class);
    }
}
