<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {
    Route::get('reservations/datatable', 'ReservationController@datatable')
        ->name('reservations.datatable');


    Route::get('reservations/deletes', 'ReservationController@deletes')
        ->name('reservations.deletes');

    Route::resource('reservations', 'ReservationController')->names('reservations');

    Route::get('reservations_calendar', 'ReservationCalendarController@index')
        ->name('reservations_calendar.index');
    Route::get('reservations_calendar/by-date', 'ReservationCalendarController@byDate')
        ->name('reservations_calendar.by_date');
    Route::post('reservations_calendar/store', 'ReservationCalendarController@store')
        ->name('reservations_calendar.store');
    Route::post('reservations_calendar/delete', 'ReservationCalendarController@delete')
        ->name('reservations_calendar.delete');

    Route::post('reservations/store', 'ReservationController@store')
        ->name('reservations.store');
});
