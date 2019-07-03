<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Site;
use Faker\Generator as Faker;

$factory->define(Site::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
        'url' => $faker->url,
        'email' => $faker->safeEmail,
    ];
});
