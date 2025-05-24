<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {
    ///////blogs
    Route::get('blogs/datatable', 'BlogController@datatable')
        ->name('blogs.datatable');
    Route::get('blogs/deletes', 'BlogController@deletes')
        ->name('blogs.deletes');
    Route::resources([
        'blogs'               => 'BlogController',
    ]);
});
