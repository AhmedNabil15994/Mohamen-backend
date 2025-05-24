<?php

Route::group(['prefix' => 'areas'], function () {
    Route::get('cities', 'AreaController@cities');
    Route::get('countries', 'AreaController@countries');
    Route::get('cities/{id}/states', 'AreaController@states');
});
