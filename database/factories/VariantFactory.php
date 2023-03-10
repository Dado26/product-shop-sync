<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Variant;
use Faker\Generator as Faker;


$factory->define(Variant::class, function (Faker $faker) {
    return [
        'name' => $faker->words(3, true),
        'price' => $faker->numberBetween(300,40000),
    ];
});

