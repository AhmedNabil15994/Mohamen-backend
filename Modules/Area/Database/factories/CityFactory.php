<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Area\Entities\City;
use Modules\Area\Entities\Country;

$factory->define(City::class, function (Faker $faker) {
    return [
        'status'=>1,
        'country_id'=> factory(Country::class),
        'title'     => $faker->sentence(),
    ];
});
