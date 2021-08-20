<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use App\RegisterUser;
use Faker\Generator as Faker;

$factory->define(RegisterUser::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'token' => hash_hmac('sha256', Str::random(40), config('app.key')),
        'name' => $faker->name,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'created_at' => now(),
    ];
});
