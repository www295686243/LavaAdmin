<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Coupon\CouponMarketController;
use App\Http\Controllers\Api\Coupon\CouponOrderController;
use App\Http\Controllers\Api\Info\InfoDeliveryController;
use App\Http\Controllers\Api\Info\InfoComplaintController;
use App\Http\Controllers\Api\Info\InfoViewController;
use App\Http\Controllers\Api\Task\TaskRecordController;
use App\Http\Controllers\Api\User\Info\HrJobController;
use App\Http\Controllers\Api\User\Info\HrResumeController;
use App\Http\Controllers\Api\User\Info\InfoCheckController;
use App\Http\Controllers\Api\User\NotifyController;
use App\Http\Controllers\Api\User\UserCashController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\UserCouponController;
use App\Http\Controllers\Api\User\UserEnterpriseAuthController;
use App\Http\Controllers\Api\User\UserEnterpriseController;
use App\Http\Controllers\Api\User\UserOrderController;
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
  Route::get('user/getWallet', [UserController::class, 'getWallet']);
  Route::get('user/getBill', [UserController::class, 'getBill']);
  Route::post('user/setInviteUser', [UserController::class, 'setInviteUser']);
  Route::get('user/checkOfficialAccounts', [UserController::class, 'checkOfficialAccounts']);
  Route::post('user/baseInfoUpdate', [UserController::class, 'baseInfoUpdate']);
  Route::get('user/isFreeForLimitedTime', [UserController::class, 'isFreeForLimitedTime']);
  Route::post('user/switchRole', [UserController::class, 'switchRole']);

  Route::apiResource('user_personal_auth', UserPersonalAuthController::class)->only(['show', 'store']);
  Route::apiResource('user_enterprise_auth', UserEnterpriseAuthController::class)->only(['show', 'store']);
  Route::post('user_personal/check', [UserPersonalController::class, 'check']);
  Route::apiResource('user_personal', UserPersonalController::class)->only(['show', 'update']);
  Route::apiResource('user_enterprise', UserEnterpriseController::class)->only(['show', 'update']);
  Route::apiResource('user_cash', UserCashController::class)->only(['index', 'store', 'update']);

  Route::apiResource('image', ImageController::class)->only(['store']);
  Route::post('wechat/notify', [WeChatController::class, 'notify']);

  // 通知
  Route::get('notify/getUnreadCount', [NotifyController::class, 'getUnreadCount']);
  Route::get('notify/markHaveRead', [NotifyController::class, 'markHaveRead']);
  Route::apiResource('notify', NotifyController::class)->only(['index', 'show']);

  // 支付
  Route::post('hr_job/pay', [\App\Http\Controllers\Api\Info\HrJobController::class, 'pay']);
  Route::post('hr_resume/pay', [\App\Http\Controllers\Api\Info\HrResumeController::class, 'pay']);
  Route::get('hr_job/getContacts', [\App\Http\Controllers\Api\Info\HrJobController::class, 'getContacts']);
  Route::get('hr_resume/getContacts', [\App\Http\Controllers\Api\Info\HrResumeController::class, 'getContacts']);
  // 信息
  Route::post('user/hr_job/refreshUpdateAt', [HrJobController::class, 'refreshUpdateAt']);
  Route::post('user/hr_job/updateDisable', [HrJobController::class, 'updateDisable']);
  Route::apiResource('user/hr_job', HrJobController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
  Route::get('hr_job/view', [\App\Http\Controllers\Api\Info\HrJobController::class, 'view']);
  Route::apiResource('hr_job', \App\Http\Controllers\Api\Info\HrJobController::class)->only(['index', 'show']);

  Route::post('user/hr_resume/refreshUpdateAt', [HrResumeController::class, 'refreshUpdateAt']);
  Route::post('user/hr_resume/updateDisable', [HrResumeController::class, 'updateDisable']);
  Route::apiResource('user/hr_resume', HrResumeController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
  Route::get('hr_resume/view', [\App\Http\Controllers\Api\Info\HrResumeController::class, 'view']);
  Route::apiResource('hr_resume', \App\Http\Controllers\Api\Info\HrResumeController::class)->only(['index', 'show']);
  // 优惠券
  Route::post('user_coupon/recall', [UserCouponController::class, 'recall']);
  Route::get('user_coupon/getUsableCoupon', [UserCouponController::class, 'getUsableCoupon']);
  Route::apiResource('user_coupon', UserCouponController::class)->only(['index']);
    // 优惠券市场
  Route::apiResource('coupon_market', CouponMarketController::class)->only(['index', 'store']);
  Route::get('coupon_order/checkUnpaidOrder', [CouponOrderController::class, 'checkUnpaidOrder']);
  Route::post('coupon_order/continueUnpaidOrder', [CouponOrderController::class, 'continueUnpaidOrder']);
  Route::post('coupon_order/cancelUnpaidOrder', [CouponOrderController::class, 'cancelUnpaidOrder']);
  Route::apiResource('coupon_order', CouponOrderController::class)->only(['store']);

  // 信息审核
  Route::apiResource('info_check', InfoCheckController::class)->only(['index', 'show', 'destroy']);
  // 信息投诉
  Route::get('info_complaint/getInfoComplaint', [InfoComplaintController::class, 'getInfoComplaint']);
  Route::apiResource('info_complaint', InfoComplaintController::class)->only(['store']);
  // 信息投递
  Route::get('info_delivery/getInfoList', [InfoDeliveryController::class, 'getInfoList']);
  Route::apiResource('info_delivery', InfoDeliveryController::class)->only(['index', 'store', 'show']);
  // 任务记录
  Route::apiResource('task_record', TaskRecordController::class)->only(['store']);
  // 查看订单
  Route::apiResource('user_order', UserOrderController::class)->only(['index']);
});

// 支付回调 为了在chart表中区别是支付哪些信息类型的
Route::any('hr_job/pay_callback', [\App\Http\Controllers\Api\Info\HrJobController::class, 'payCallback']);
Route::any('hr_resume/pay_callback', [\App\Http\Controllers\Api\Info\HrResumeController::class, 'payCallback']);
