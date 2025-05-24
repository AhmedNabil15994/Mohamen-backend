<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Service\Entities\Service;

$factory->define(Service::class, function (Faker $faker) {
    $fakerAr = \Faker\Factory::create('ar_JO');
    $langSentence = ['ar' => $fakerAr->firstName(), 'en' => $faker->sentence(3)];
    return [
        'status' => rand(0, 1),
        'desc' => $langSentence,
        'title' => $langSentence
    ];
});


$factory->afterCreating(Service::class, function (Service $model, Faker $faker) {
    try {
        //code...
        $model->addMediaFromUrl(url($faker->imageUrl()))->toMediaCollection('images');
    } catch (\Throwable $th) {
        //throw $th;
    }
});
