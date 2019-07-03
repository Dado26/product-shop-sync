<?php

use App\User;
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
        factory(Site::class, 30)->create([
            'user_id' => User::first()->id,
        ]);
    }
}
