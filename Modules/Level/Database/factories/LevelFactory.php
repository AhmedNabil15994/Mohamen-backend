<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Level\Entities\Level;

$factory->define(Level::class, function (Faker $faker) {
    return [
        'title'=>['ar'=>$faker->sentence(2),'en'=>$faker->sentence(2)],
        'winning_count'=>rand(1, 4),
    ];
});
