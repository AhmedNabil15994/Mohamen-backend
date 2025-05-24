<?php
Route::post('fcm-token', 'FCMTokenController@store');
Route::group(['prefix' => 'user', 'middleware' => 'auth:sanctum'], function () {
  Route::controller('UserController')->group(function () {
    Route::get('profile', 'profile')->name('api.users.profile');
    Route::get('generate-uid', 'generateUid')->name('api.users.generateUid');
    Route::post('profile', 'updateProfile')->name('api.users.profile');
    Route::get('reservations', 'myReservations');
    Route::get('notifications', 'myNotifications');
    Route::get('upcoming-reservations', 'upcomingReservations');
  });
});
