<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title'          => $faker->word(2, true),
        'description'    => $faker->text(60),
        'status'         => $faker->randomElement([Product::STATUS_AVAILABLE, Product::STATUS_UNAVAILABLE]),
        'url'            => $faker->url,
        'specifications' => '',
        'synced_at'      => now(),
    ];
});

$factory->state(Product::class, 'available', [
    'status' => Product::STATUS_AVAILABLE,
]);
