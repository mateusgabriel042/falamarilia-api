<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Notice;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Notice::class, function (Faker $faker) {
    $notices = ['Notícia', 'Aviso'];

    return [
        'title' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'description' => $faker->paragraph($nbSentences = 2, $variableNbSentences = true),
        'type' => $notices[array_rand($notices, 1)],
        'expired_at' => Carbon::now()->addDays(15)
    ];
});
