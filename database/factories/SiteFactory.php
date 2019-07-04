<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Site;
use Faker\Generator as Faker;

$factory->define(Site::class, function (Faker $faker) {
    $name = $faker->domainWord;

    return [
        'name' => ucfirst($name),
        'url' => "https://www.$name.com",
        'email' => $faker->safeEmail,
    ];
});