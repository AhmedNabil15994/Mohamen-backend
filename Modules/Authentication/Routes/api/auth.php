<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'LoginController@postLogin')->name('api.auth.login');
    Route::post('register', 'RegisterController@register')->name('api.auth.register');
    Route::post('forget-password', 'ForgotPasswordController@forgetPassword')->name('api.auth.password.forget');

    Route::group(['prefix' => '/', 'middleware' => 'auth:sanctum'], function () {
        Route::post('logout', 'LoginController@logout')->name('api.auth.logout');
        Route::get('profile', 'ProfileController@Profile')->name('api.auth.profile');
        Route::get('profile/subscription', 'ProfileController@clientSubscription')->name('api.auth.profile.subscription');
        Route::post('profile', 'ProfileController@updateProfile')->name('api.auth.update.profile');
        Route::put('change-password', 'UpdatePasswordController@UpdatePassword')->name('api.auth.change.password');
    });
});
