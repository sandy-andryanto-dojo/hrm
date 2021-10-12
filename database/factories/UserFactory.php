<?php

use Faker\Generator as Faker;
use App\Models\Auth\User;
use App\Models\Auth\UserConfirm;

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
    static $password;
    $totalUsers = UserConfirm::count();
    return [
        'username' => $totalUsers == 0 ? "admin" : $faker->unique()->userName,
        'email' => $totalUsers == 0 ? "admin@devel.com" : $faker->unique()->safeEmail,
        'phone'=>$faker->phoneNumber,
        'email_confirm'=>1,
        'phone_confirm'=>1,
        'is_root'=> $totalUsers == 0 ? 1 : 0,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
