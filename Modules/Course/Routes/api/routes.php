<?php

use Illuminate\Support\Facades\Route;

Route::get('courses', 'CourseController@index');
Route::get('courses/video-info/{id}', 'CourseController@getVideoInfo');
Route::get('courses/{id}', 'CourseController@show');
