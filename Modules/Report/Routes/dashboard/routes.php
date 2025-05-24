<?php

use Illuminate\Support\Facades\Route;

Route::name('dashboard.')->group(function () {


    Route::get('reports/sales', 'ReportController@salesReport')
        ->name('reports.sales');



});
