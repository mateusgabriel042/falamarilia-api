<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'color' => '#eb5657',
        'icon' => 'noImage',
        'active' => rand(0, 1),
    ];
});
