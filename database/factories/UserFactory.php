<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->safeEmail,
        'password' => bcrypt('asdasd'),
        'admin' => false,
    ];
});
