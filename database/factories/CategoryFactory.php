<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'label' => $faker->name,
        'icon' => 'noImage',
        'active' => rand(0, 1)
    ];
});
