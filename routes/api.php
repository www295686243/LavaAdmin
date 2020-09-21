<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function () {
  Route::get('app/getAppConfig', 'AppController@getAppConfig');
  Route::post('user/login', 'User\UserController@login');
  Route::get('wechat/getConfig', 'WeChatController@getConfig');
  Route::post('wechat/auth', 'WeChatController@auth');
  Route::post('wechat/login', 'WeChatController@login');
  Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('api_log', 'ApiLogController')->only(['store']);

    Route::post('user/todayFirstLogin', 'User\UserController@todayFirstLogin');
    Route::get('user/getUserInfo', 'User\UserController@getUserInfo');
    Route::get('user/getBaseUserInfo', 'User\UserController@getBaseUserInfo');
    Route::post('user/sendSmsCaptcha', 'User\UserController@sendSmsCaptcha');
    Route::post('user/bindPhone', 'User\UserController@bindPhone');
    Route::post('user/updatePhone', 'User\UserController@updatePhone');
    Route::post('user/verifyPhone', 'User\UserController@verifyPhone');
    Route::apiResource('user_personal_auth', 'User\UserPersonalAuthController')->only(['show', 'store']);
    Route::apiResource('user_enterprise_auth', 'User\UserEnterpriseAuthController')->only(['show', 'store']);

    Route::apiResource('image', 'ImageController')->only(['store']);
    Route::post('wechat/notify', 'WeChatController@notify');

    // 通知
    Route::get('notify/getUnreadCount', 'User\NotifyController@getUnreadCount');
    Route::get('notify/markHaveRead', 'User\NotifyController@markHaveRead');
    Route::apiResource('notify', 'User\NotifyController')->only(['index', 'show']);

    // 信息
    Route::apiResource('news', 'NewsController')->only(['index']);
    Route::apiResource('user/hr', 'User\Info\HrController')->only(['index', 'store', 'show', 'destroy']);
    // 优惠券
    Route::apiResource('user_coupon', 'User\UserCouponController')->only(['index']);

    // 支付
    Route::post('news/pay', 'NewsController@pay');

    // 信息审核
    Route::apiResource('info_check', 'Info\InfoCheckController')->only(['index', 'destroy']);
  });

  // 支付回调 为了在chart表中区别是支付哪些信息类型的
  Route::any('news/pay_callback', 'NewsController@payCallback');
});