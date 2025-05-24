<?php

use Illuminate\Support\Facades\Route;
// coupons
Route::group(['prefix' => 'coupons'], function () {
    Route::post('/check', 'CouponController@check');
    Route::post('/check-lawyers-coupon', 'CouponController@checkLawyerCoupon');
});
