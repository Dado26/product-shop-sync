<?php

use App\Models\Site;
use App\Models\SyncRules;
use Illuminate\Database\Seeder;

class SyncRulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Site::all()->each(function ($site) {
            factory(SyncRules::class)->create(['site_id' => $site->id]);
        });
    }
}
