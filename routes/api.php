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
  Route::post('user/login', 'UserController@login');
  Route::get('wechat/getConfig', 'WeChatController@getConfig');
  Route::post('wechat/auth', 'WeChatController@auth');
  Route::post('wechat/login', 'WeChatController@login');
  Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('api_log', 'ApiLogController')->only(['store']);

    Route::post('user/todayFirstLogin', 'UserController@todayFirstLogin');
    Route::get('user/getUserInfo', 'UserController@getUserInfo');
    Route::get('user/getBaseUserInfo', 'UserController@getBaseUserInfo');
    Route::post('user/sendSmsCaptcha', 'UserController@sendSmsCaptcha');
    Route::post('user/bindPhone', 'UserController@bindPhone');
    Route::post('user/updatePhone', 'UserController@updatePhone');
    Route::post('user/verifyPhone', 'UserController@verifyPhone');
    Route::apiResource('user_personal_auth', 'User\UserPersonalAuthController')->only(['show', 'store']);
    Route::apiResource('user_enterprise_auth', 'User\UserEnterpriseAuthController')->only(['show', 'store']);

    Route::apiResource('image', 'ImageController')->only(['store']);
    Route::post('wechat/notify', 'WeChatController@notify');

    // 通知
    Route::get('notify/getUnreadCount', 'NotifyController@getUnreadCount');
    Route::get('notify/markHaveRead', 'NotifyController@markHaveRead');
    Route::apiResource('notify', 'NotifyController')->only(['index', 'show']);

    // 信息
    Route::apiResource('news', 'NewsController')->only(['index']);
    // 优惠券
    Route::apiResource('user_coupon', 'User\UserCouponController')->only(['index']);

    // 支付
    Route::post('news/pay', 'NewsController@pay');
  });

  // 支付回调 为了在chart表中区别是支付哪些信息类型的
  Route::any('news/pay_callback', 'NewsController@payCallback');
});