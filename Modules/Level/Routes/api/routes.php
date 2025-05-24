<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'levels'], function () {
    Route::get('/', 'LevelController@index');
});

