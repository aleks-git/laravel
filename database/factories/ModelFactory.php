<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});



$factory->defineAs(App\Staff::class, 'staffs', function (Faker $faker) {
    $faker = \Faker\Factory::create('ru_RU');
    $preffix = $faker->randomLetter.$faker->numberBetween($min = 1000, $max = 9000);
    return [
        'full_name' => $faker->name,
        'email' => $preffix.$faker->unique()->safeEmail,
        'parent_id' => '0',
        'salary' => 3000,
        'employ_at' => $faker->dateTimeBetween($startDate = '-10 years', $endDate = '-2 day', $timezone = 'Europe/Kiev')
    ];
});




$factory->defineAs(App\Position::class, 'positions', function (Faker $faker) {
    $faker = \Faker\Factory::create('ru_RU');
    return [
        'name' => $faker->jobTitle,
    ];
});
