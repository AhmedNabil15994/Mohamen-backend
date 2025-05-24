<?php

Route::get('services', 'ServiceController@index')->name('frontend.services.index');
Route::get('services/media-center', 'ServiceController@mediaCenter')->name('frontend.services.media_center');
Route::get('service/{slug}', 'ServiceController@show')->name('frontend.services.show');
