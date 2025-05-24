<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'orders'], function () {
    Route::controller('OrderController')->group(function () {
        Route::get('/', 'list')->middleware('auth:sanctum');
        Route::post('store', 'store')->middleware('auth:sanctum');
        
        Route::get('success', 'success')->name('api.orders.success');
        Route::get('failed', 'failed')->name('api.orders.failed');
        Route::post('webhook', 'webhook')->name('api.orders.webhook');
    });
});
