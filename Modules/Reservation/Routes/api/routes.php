<?php

use Illuminate\Support\Facades\Route;
use Modules\Reservation\Entities\Reservation;

Route::group(['prefix' => 'reservations'], function () {
  Route::get('/{id}', 'ReservationController@show')->middleware('auth:sanctum')->where('id', '[0-9]+');
  Route::post('/reserve', 'ReservationController@reserve')->middleware('auth:sanctum');
  Route::controller('AfterPaidController')->group(function () {
    Route::get('success', 'success')->name('api.reservations.success');
    Route::get('failed', 'failed')->name('api.reservations.failed');
    Route::get('notify', 'updatePaidStatus')->name('api.reservations.notify');
  });

  Route::get('update-finish-time', function () {
    Reservation::where('finish_time', null)->get()->each(function ($reservation) {
      $reservation->update(['finish_time' => \Carbon\Carbon::parse($reservation->first_time)->addHour()]);
    });
    return 'done';
  });

});
