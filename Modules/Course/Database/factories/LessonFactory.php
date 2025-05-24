<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Lesson as Model;

$factory->define(Model::class, function (Faker $faker) {
    $fakerAr = \Faker\Factory::create('ar_JO');
    $langSentence = ['ar' => $fakerAr->firstName(), 'en' => $faker->sentence(3)];
    return [
        'title'                             => $langSentence,
        'status'                            => rand(0, 1),
        'course_id'                         => factory(Course::class)
    ];
});


$factory->afterCreating(Model::class, function (Model $model, Faker $faker) {
    try {
        $model->addMediaFromUrl($faker->imageUrl())->toMediaCollection('images');
    } catch (\Throwable $th) {
        //throw $th;
    }
});
