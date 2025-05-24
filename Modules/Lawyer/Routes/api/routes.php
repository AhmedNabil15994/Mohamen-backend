<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'lawyers'], function () {
    Route::controller('LawyerController')->group(function ($route) {
        $route->get('/', 'index');
        $route->get('/services/{id}', 'services');
        $route->get('/available-times', 'findLawyerAvailabilities');
    });
});
