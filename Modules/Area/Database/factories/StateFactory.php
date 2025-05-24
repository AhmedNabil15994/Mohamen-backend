<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Area\Entities\City;
use Modules\Area\Entities\State;

$factory->define(State::class, function (Faker $faker) {
    return [
        'status' => 1,
        'city_id' => factory(City::class),
        'title'     => $faker->sentence(),
    ];
});
