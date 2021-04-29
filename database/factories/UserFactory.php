<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factories\Factory $factory */

use App\Models\Settlemet;
use App\Models\Sport;
use App\Models\User;
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

$factory->define(User::class, function (Faker $faker) {
    $settlementsCount = Settlemet::query()->count();
    $sportsCount      = Sport::query()->count();

    return [
        'first_name'    => $faker->name,
        'last_name'     => $faker->name,
        'email'         => $faker->unique()->safeEmail,
        'password'      => 'password',
        'settlement_id' => rand(1, $settlementsCount),
        'sport_id'      => rand(1, $sportsCount),
    ];
});
