<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Info\InfoCheckController;
use App\Http\Controllers\Api\User\Info\HrJobController;
use App\Http\Controllers\Api\User\NotifyController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\UserCouponController;
use App\Http\Controllers\Api\User\UserEnterpriseAuthController;
use App\Http\Controllers\Api\User\UserPersonalAuthController;
use App\Http\Controllers\Api\User\UserPersonalController;
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

Route::get('app/getAppConfig', [AppController::class, 'getAppConfig']);
Route::post('user/login', [UserController::class, 'login']);
Route::get('wechat/getConfig', [WeChatController::class, 'getConfig']);
Route::post('wechat/auth', [WeChatController::class, 'auth']);
Route::post('wechat/login', [WeChatController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
  Route::apiResource('api_log', ApiLogController::class)->only(['store']);

  Route::post('user/todayFirstLogin', [UserController::class, 'todayFirstLogin']);
  Route::get('user/getUserInfo', [UserController::class, 'getUserInfo']);
  Route::get('user/getBaseUserInfo', [UserController::class, 'getBaseUserInfo']);
  Route::post('user/sendSmsCaptcha', [UserController::class, 'sendSmsCaptcha']);
  Route::post('user/bindPhone', [UserController::class, 'bindPhone']);
  Route::post('user/updatePhone', [UserController::class, 'updatePhone']);
  Route::post('user/verifyPhone', [UserController::class, 'verifyPhone']);
  Route::apiResource('user_personal_auth', UserPersonalAuthController::class)->only(['show', 'store']);
  Route::apiResource('user_enterprise_auth', UserEnterpriseAuthController::class)->only(['show', 'store']);
  Route::apiResource('user_personal', UserPersonalController::class)->only(['show', 'update']);

  Route::apiResource('image', ImageController::class)->only(['store']);
  Route::post('wechat/notify', [WeChatController::class, 'notify']);

  // 通知
  Route::get('notify/getUnreadCount', [NotifyController::class, 'getUnreadCount']);
  Route::get('notify/markHaveRead', [NotifyController::class, 'markHaveRead']);
  Route::apiResource('notify', NotifyController::class)->only(['index', 'show']);

  // 信息
  Route::apiResource('news', NewsController::class)->only(['index']);
  Route::apiResource('user/hr_job', HrJobController::class)->only(['index', 'store', 'show', 'destroy']);
  // 优惠券
  Route::apiResource('user_coupon', UserCouponController::class)->only(['index']);

  // 支付
  Route::post('news/pay', [NewsController::class, 'pay']);

  // 信息审核
  Route::apiResource('info_check', InfoCheckController::class)->only(['index', 'destroy']);

});

// 支付回调 为了在chart表中区别是支付哪些信息类型的
Route::any('news/pay_callback', [NewsController::class, 'payCallback']);
