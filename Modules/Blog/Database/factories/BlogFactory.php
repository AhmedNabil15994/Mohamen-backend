<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Blog\Entities\Blog;

$factory->define(Blog::class, function (Faker $faker) {
    $fakerAr = \Faker\Factory::create('ar_JO');
    $langSentence = ['ar' => $fakerAr->firstName(), 'en' => $faker->sentence(3)];
    return [
        'status' => rand(0, 1),
        'desc' => $langSentence,
        'title' => $langSentence
    ];
});


$factory->afterCreating(Blog::class, function (Blog $model, Faker $faker) {
    $model->addMediaFromUrl(url($faker->imageUrl()))->toMediaCollection('images');
});
