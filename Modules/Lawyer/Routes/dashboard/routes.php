<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {
    Route::get('lawyers/datatable', 'LawyerController@datatable')
        ->name('lawyers.datatable');

    Route::get('lawyers/deletes', 'LawyerController@deletes')
        ->name('lawyers.deletes');
    Route::get('club-lawyers/clubs', 'LawyerClubController@index')
        ->name('lawyers.dashboard.clubs');
    Route::get('club-lawyers/{clubId}/reservations', 'LawyerClubController@reservations')->name('lawyers.clubs.reservations');


    Route::resource('lawyers', 'LawyerController')->names('lawyers');
    Route::get('ajax-lawyer-services', 'LawyerController@ajaxServices')->name('lawyers.ajax.services');
    Route::get('ajax-lawyer-avaiable-times', 'LawyerController@ajaxAvailableTimes')->name('lawyers.ajax.avaiable_times');
});
