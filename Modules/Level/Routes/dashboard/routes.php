<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {
    Route::get('levels/datatable', 'LevelController@datatable')
        ->name('levels.datatable');

    Route::get('levels/deletes', 'LevelController@deletes')
        ->name('levels.deletes');

    Route::resource('levels', 'LevelController')->names('levels');
});
