<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Modules\Lawyer\Entities\Lawyer;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;

$factory->define(Lawyer::class, function (Faker $faker) {
    return factory(User::class)->raw();
});


$factory->afterMaking(Lawyer::class, function ($lawyer, $faker) {
    $role = Role::whereHas('permissions', function ($query) {
        $query->where('name', 'lawyer_access');
    })->first();
    $lawyer->assignRole($role);
    $lawyer->addMediaFromUrl($faker->imageUrl())->toMediaCollection('images');
});
