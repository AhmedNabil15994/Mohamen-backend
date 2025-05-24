<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\User\Entities\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'=>$faker->name('male'),
        'email'=>$faker->email(),
        'password'=>'12345678',
        'mobile'=>$faker->phoneNumber(),
    ];
});




$factory->afterCreating(User::class, function (User $club, Faker $faker) {
    $club->addMediaFromUrl($faker->imageUrl())->toMediaCollection('images');
});
