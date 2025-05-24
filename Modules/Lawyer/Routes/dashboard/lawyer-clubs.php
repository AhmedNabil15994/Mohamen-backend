<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {

    Route::get('club-lawyers/clubs', 'LawyerClubController@index')
        ->name('lawyers.dashboard.clubs');

    Route::get('club-lawyers/{clubId}/reservations', 'LawyerClubController@reservations')->name('lawyers.clubs.reservations');

    Route::get('club-lawyers/reservations/{id}', 'LawyerClubController@show')->name('lawyers.clubs.reservations.show')->where('id', '[0-9]+');

    Route::delete('club-lawyers/reservations/{id}/delete', 'LawyerClubController@destroy')->name('lawyers.clubs.reservations.delete');
    Route::get('club-lawyers/reservations/multiDelete', 'LawyerClubController@deletes')->name('lawyers.clubs.reservations.deletes');
});
