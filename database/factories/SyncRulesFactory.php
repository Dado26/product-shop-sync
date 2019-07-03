<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\SyncRules;
use Faker\Generator as Faker;

$factory->define(SyncRules::class, function (Faker $faker) {
    return [
        'title' => $faker->randomElement(['.title', '#title', '.title > a']),
        'description' => $faker->randomElement(['.description', '#description', '.description > p']),
        'price' => $faker->randomElement(['.price', '#price', '.price > span']),
        'in_stock' => $faker->randomElement(['.in-stock', '.stock', '.available']),
        'in_stock_value' => $faker->randomElement(['Available', 'In Stock']),
        'images' => $faker->randomElement(['.product > img', '#product a > img', '.product-img']),
        'variants' => $faker->randomElement(['.product .variant', '#product .variant', '.product > .variants > span']),
    ];
});
