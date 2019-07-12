<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@mail.com',
            'password' => bcrypt('asdasd'),
            'admin' => true,
        ]);

        factory(User::class, 4)->create();
    }
}
