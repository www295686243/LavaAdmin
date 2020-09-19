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

Route::namespace('Admin')->group(function () {
  Route::post('auth/login', 'AuthController@login');
  Route::post('auth/loginStat', 'AuthController@loginStat');
  Route::get('app/getAppConfig', 'AppController@getAppConfig');
  Route::middleware(['auth:sanctum', 'interface.permission'])->group(function () {
    Route::get('auth/getUserConfig', 'AuthController@getUserConfig');
    // 系统配置
    Route::apiResource('config', 'ConfigController');
    Route::apiResource('config_option', 'ConfigOptionController');
    // 后台日志
    Route::apiResource('admin_log', 'AdminLogController')->only(['index']);
    // 前台日志
    Route::apiResource('api_log', 'ApiLogController')->only(['index', 'show']);
    // 职位
    Route::get('position/getPermissions/{id}', 'User\PositionController@getPermissions');
    Route::get('position/getAssignPermissions/{id}', 'User\PositionController@getAssignPermissions');
    Route::post('position/updatePermissions/{id}', 'User\PositionController@updatePermissions');
    Route::post('position/updateAssignPermissions/{id}', 'User\PositionController@updateAssignPermissions');
    Route::apiResource('position', 'User\PositionController')->except(['destroy']);
    // 员工
    Route::apiResource('employee', 'User\EmployeeController');
    // 会员
    Route::apiResource('user', 'User\UserController');
    Route::apiResource('user_personal', 'User\UserPersonalController');
    Route::apiResource('user_enterprise', 'User\UserEnterpriseController');
    Route::apiResource('user_control', 'User\UserControlController');
    Route::apiResource('user_coupon', 'User\UserCouponController')->only(['index', 'store']);
    Route::apiResource('user_personal_auth', 'User\UserPersonalAuthController')->only(['index', 'show', 'update']);
    Route::apiResource('user_enterprise_auth', 'User\UserEnterpriseAuthController')->only(['index', 'show', 'update']);
    // 角色
    Route::get('role/getPermissions/{id}', 'User\RoleController@getPermissions');
    Route::get('role/getAssignPermissions/{id}', 'User\RoleController@getAssignPermissions');
    Route::post('role/updatePermissions/{id}', 'User\RoleController@updatePermissions');
    Route::post('role/updateAssignPermissions/{id}', 'User\RoleController@updateAssignPermissions');
    Route::apiResource('role', 'User\RoleController')->except(['destroy']);
    // 图片
    Route::post('image/destroyMore', 'ImageController@destroyMore');
    Route::apiResource('image', 'ImageController')->only(['index', 'store', 'destroy']);
    // 新闻
    Route::apiResource('news', 'NewsController');
    // 版本
    Route::apiResource('version', 'VersionController')->only(['index', 'update', 'show']);
    // 通知记录
    Route::apiResource('notify', 'Notify\NotifyController')->only(['index', 'show']);
    // 通知模板
    Route::apiResource('notify_template', 'Notify\NotifyTemplateController')->only(['index', 'show', 'store', 'update']);
    // 通知用户
    Route::apiResource('notify_user', 'Notify\NotifyUserController')->only(['index', 'store', 'destroy']);
    // 图表
    Route::get('chart/createTodayData', 'ChartController@createTodayData');
    Route::get('chart/getCurrentMonthData', 'ChartController@getCurrentMonthData');
    Route::get('chart/getCurrentYearData', 'ChartController@getCurrentYearData');
    // 优惠券模板
    Route::get('coupon_template/getAll', 'CouponTemplateController@getAll');
    Route::apiResource('coupon_template', 'CouponTemplateController')->only(['index', 'store', 'show', 'update']);
    // 订单记录
    Route::apiResource('user_order', 'User\UserOrderController')->only(['index', 'show']);
    // 账单记录
    Route::apiResource('user_bill', 'User\UserBillController')->only(['index']);
    // 信息审核
    Route::apiResource('info_check', 'Info\InfoCheckController')->only(['index', 'show', 'update']);
  });
});