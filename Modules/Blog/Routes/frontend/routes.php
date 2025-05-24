<?php

Route::get('blogs', 'BlogController@index')->name('frontend.blogs.index');
Route::get('blogs/media-center', 'BlogController@mediaCenter')->name('frontend.blogs.media_center');
Route::get('blog/{slug}', 'BlogController@show')->name('frontend.blogs.show');
