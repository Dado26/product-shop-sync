<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model\Variant;
use Faker\Generator as Faker;


$factory->define(Variant::class, function (Faker $faker) {
    return [
        'name' => $faker->name(), 
        'price' => $faker->numberBetween(100,100000),
    ];
});

