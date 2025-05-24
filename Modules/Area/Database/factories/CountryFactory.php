<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Area\Entities\Country;

$factory->define(Country::class, function (Faker $faker) {
    return [
        'status'=>1,
        'title'=>$faker->country(),
    ];
});
