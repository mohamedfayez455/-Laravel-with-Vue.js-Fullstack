<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$products=[
    "product1",
    "product2",
    "product3",
    "product4",
    "product5",
    "product6",
    "product7",
    "product8",
    "product9",
    "product10",
];
$factory->define(Product::class, function (Faker $faker) use($products) {
    return [
        "title" => Arr::random($products),
        "description" => $faker->text(),
        "price" => random_int(20,200),
    ];
});
