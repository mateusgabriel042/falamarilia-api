<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Solicitation;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(Solicitation::class, function (Faker $faker) {
    $status = ['Aguardando Resposta', 'Respondida', 'Finalizada'];

    return [
        'service_id' => 1,
        'user_id' => 1,
        'category_id' => 1,
        'status' => $status[array_rand($status, 1)],
        'description' => $faker->paragraph($nbSentences = 2, $variableNbSentences = true),
        'photo' => 'noImage',
        'geolocation' => 'NULL',
    ];
});
