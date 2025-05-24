<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {
    ///////services
    Route::get('services/datatable', 'ServiceController@datatable')
        ->name('services.datatable');
    Route::get('services/deletes', 'ServiceController@deletes')
        ->name('services.deletes');
    Route::resources([
        'services'               => 'ServiceController',
    ]);
});
