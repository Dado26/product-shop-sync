<?php

use App\Models\User;
use App\Models\Site;
use Illuminate\Database\Seeder;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Site::class, 6)->create([
            'user_id' => User::first()->id,
        ]);
    }
}
