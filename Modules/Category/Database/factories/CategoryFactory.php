<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Category\Entities\Category;


$factory->define(Category::class, function (Faker $faker) {
    $fakerAr = \Faker\Factory::create('ar_JO');
    $langSentence = ['ar' => $fakerAr->firstName(), 'en' => $faker->sentence(3)];
    return [
        'status' => rand(0, 1),
        'type' => 1,
        'category_id' => null,
        'title' => $langSentence
    ];
});


$factory->afterCreating(Category::class, function (Category $category, Faker $faker) {
    try {
        $category->addMediaFromUrl($faker->imageUrl())->toMediaCollection('images');
    } catch (\Throwable $th) {
        //throw $th;
    }
});
