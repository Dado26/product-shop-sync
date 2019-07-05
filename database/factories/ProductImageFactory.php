<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\ProductImage;
use Faker\Generator as Faker;

$factory->define(ProductImage::class, function (Faker $faker) {
    return [
        'url' => $faker->url,
    ];
});
