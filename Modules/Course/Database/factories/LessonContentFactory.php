<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Course\Entities\Lesson;
use Modules\Course\Entities\LessonContent as Model;

$factory->define(Model::class, function (Faker $faker) {
    $fakerAr = \Faker\Factory::create('ar_JO');
    $langSentence = ['ar' => $fakerAr->firstName(), 'en' => $faker->sentence(3)];
    return [
        'title'                             => $langSentence,
        'order'                             => 1,
        'type'                              => 'video',
        'lesson_id'                         => factory(Lesson::class)
    ];
});
