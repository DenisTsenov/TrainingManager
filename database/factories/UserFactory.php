<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factories\Factory $factory */

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
//    $settlementSports = \DB::table('settlement_sport')->inRandomOrder()->first();

    return [
        'first_name'    => $faker->firstName,
        'last_name'     => $faker->lastName,
        'email'         => $faker->unique()->safeEmail,
        'password'      => 'password',
        'settlement_id' => 1,
        'sport_id'      => 1,
        'deleted_at'    => null,
    ];
});
