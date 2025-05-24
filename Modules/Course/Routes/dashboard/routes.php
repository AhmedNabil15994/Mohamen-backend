<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {
    ///////courses
    Route::get('courses/datatable', 'CourseController@datatable')
    ->name('courses.datatable');
    Route::get('courses/deletes', 'CourseController@deletes')
    ->name('courses.deletes');
    ///////videos
    Route::get('videos/datatable', 'VideoController@datatable')
    ->name('videos.datatable');
    Route::get('videos/deletes', 'VideoController@deletes')
    ->name('videos.deletes');
    ///////lessons
    Route::get('lessons/datatable', 'LessonController@datatable')
    ->name('lessons.datatable');
    Route::get('lessons/deletes', 'LessonController@deletes')
    ->name('lessons.deletes');
    ///////levels
    Route::get('levels/datatable', 'LevelController@datatable')
    ->name('levels.datatable');
    Route::get('levels/deletes', 'LevelController@deletes')
    ->name('levels.deletes');


    Route::get('lessoncontents/datatable', 'LessonContentController@datatable')
    ->name('lessoncontents.datatable');

    Route::get('lessoncontents/deletes', 'LessonContentController@deletes')
    ->name('lessoncontents.deletes');



    Route::get('meetings/datatable', 'MeetingController@datatable')
        ->name('meetings.datatable');

    Route::get('meetings/deletes', 'MeetingController@deletes')
        ->name('meetings.deletes');


    Route::get('coursereviews/datatable', 'CourseReviewController@datatable')
        ->name('coursereviews.datatable');

    Route::get('coursereviews/deletes', 'CourseReviewController@deletes')
        ->name('coursereviews.deletes');


    Route::resources([
        'levels'              => 'LevelController',
        'videos'              => 'VideoController',
        'courses'             => 'CourseController',
        'lessons'             => 'LessonController',
        'lessoncontents'      => 'LessonContentController',
        'meetings'            => 'MeetingController',
        'coursereviews'       => 'CourseReviewController',
        ]);
});
