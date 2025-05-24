<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Factory;
use Faker\Generator as Faker;
use Modules\Category\Entities\Category;
use Modules\Course\Entities\Course as Model;

$factory->define(Model::class, function (Faker $faker) {
    $fakerAr = \Faker\Factory::create('ar_JO');
    $langSentence = ['ar' => $fakerAr->firstName(), 'en' => $faker->sentence(3)];
    return [
        'title'                             => $langSentence,
        'desc'                              => $langSentence,
        'period'                            => rand(1, 4),
        'status'                            => rand(0, 1),
        'desc'                              => $langSentence,
        'price'                             => 10,
        'trainer'                           => $faker->name(),
    ];
});


$factory->afterCreating(Model::class, function (Model $model, Faker $faker) {

    $model->categories()->sync(
        factory(Category::class, 1)->create()->pluck('id')->toArray()
    );
    try {
        $model->addMediaFromUrl($faker->imageUrl())->toMediaCollection('images');
    } catch (\Throwable $th) {
        //throw $th;
    }
});
