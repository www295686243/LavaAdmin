<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Info\HrJobController;
use App\Http\Controllers\Admin\Info\HrResumeController;
use App\Http\Controllers\Admin\Info\IndustryController;
use App\Http\Controllers\Admin\Info\InfoCheckController;
use App\Http\Controllers\Admin\Info\InfoComplaintController;
use App\Http\Controllers\Admin\Info\InfoDeliveryController;
use App\Http\Controllers\Admin\Info\InfoProvideController;
use App\Http\Controllers\Admin\Notify\NotifyController;
use App\Http\Controllers\Admin\Notify\NotifyTemplateController;
use App\Http\Controllers\Admin\Notify\NotifyUserController;
use App\Http\Controllers\Admin\Task\TaskController;
use App\Http\Controllers\Admin\Task\TaskRuleController;
use App\Http\Controllers\Admin\User\EmployeeController;
use App\Http\Controllers\Admin\User\PositionController;
use App\Http\Controllers\Admin\User\RoleController;
use App\Http\Controllers\Admin\User\UserBillController;
use App\Http\Controllers\Admin\User\UserCashController;
use App\Http\Controllers\Admin\User\UserControlController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\User\UserCouponController;
use App\Http\Controllers\Admin\User\UserEnterpriseAuthController;
use App\Http\Controllers\Admin\User\UserEnterpriseController;
use App\Http\Controllers\Admin\User\UserOrderController;
use App\Http\Controllers\Admin\User\UserPersonalAuthController;
use App\Http\Controllers\Admin\User\UserPersonalController;
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

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/loginStat', [AuthController::class, 'loginStat']);
Route::get('app/getAppConfig', [AppController::class, 'getAppConfig']);
Route::middleware(['auth:sanctum', 'interface.permission'])->group(function () {
  Route::get('auth/getUserConfig', [AuthController::class, 'getUserConfig']);
  // 系统配置
  Route::apiResource('config', ConfigController::class);
  Route::apiResource('config_option', ConfigOptionController::class);
  // 后台日志
  Route::apiResource('admin_log', AdminLogController::class)->only(['index']);
  // 前台日志
  Route::apiResource('api_log', ApiLogController::class)->only(['index', 'show']);
  // 职位
  Route::get('position/getPermissions/{id}', [PositionController::class, 'getPermissions']);
  Route::get('position/getAssignPermissions/{id}', [PositionController::class, 'getAssignPermissions']);
  Route::post('position/updatePermissions/{id}', [PositionController::class, 'updatePermissions']);
  Route::post('position/updateAssignPermissions/{id}', [PositionController::class, 'updateAssignPermissions']);
  Route::apiResource('position', PositionController::class)->except(['destroy']);
  // 员工
  Route::apiResource('employee', EmployeeController::class);
  // 会员
  Route::apiResource('user', UserController::class);
  Route::apiResource('user_personal', UserPersonalController::class)->only(['show', 'update']);
  Route::apiResource('user_enterprise', UserEnterpriseController::class)->only(['show', 'update']);
  Route::apiResource('user_control', UserControlController::class);
  Route::apiResource('user_coupon', UserCouponController::class)->only(['index', 'store']);
  Route::apiResource('user_personal_auth', UserPersonalAuthController::class)->only(['index', 'show', 'update']);
  Route::apiResource('user_enterprise_auth', UserEnterpriseAuthController::class)->only(['index', 'show', 'update']);
  Route::apiResource('user_cash', UserCashController::class)->only(['index', 'show', 'update']);
  // 角色
  Route::get('role/getPermissions/{id}', [RoleController::class, 'getPermissions']);
  Route::get('role/getAssignPermissions/{id}', [RoleController::class, 'getAssignPermissions']);
  Route::post('role/updatePermissions/{id}', [RoleController::class, 'updatePermissions']);
  Route::post('role/updateAssignPermissions/{id}', [RoleController::class, 'updateAssignPermissions']);
  Route::apiResource('role', RoleController::class)->except(['destroy']);
  // 图片
  Route::post('image/destroyMore', [ImageController::class, 'destroyMore']);
  Route::apiResource('image', ImageController::class)->only(['index', 'store', 'destroy']);
  // 新闻
  Route::apiResource('news', NewsController::class);
  // 版本
  Route::apiResource('version', VersionController::class)->only(['index', 'update', 'show']);
  // 通知记录
  Route::apiResource('notify', NotifyController::class)->only(['index', 'show']);
  // 通知模板
  Route::apiResource('notify_template', NotifyTemplateController::class)->only(['index', 'show', 'store', 'update']);
  // 通知用户
  Route::apiResource('notify_user', NotifyUserController::class)->only(['index', 'store', 'destroy']);
  // 图表
  Route::get('chart/createTodayData', [ChartController::class, 'createTodayData']);
  Route::get('chart/getCurrentMonthData', [ChartController::class, 'getCurrentMonthData']);
  Route::get('chart/getCurrentYearData', [ChartController::class, 'getCurrentYearData']);
  // 优惠券模板
  Route::get('coupon_template/getAll', [CouponTemplateController::class, 'getAll']);
  Route::apiResource('coupon_template', CouponTemplateController::class)->only(['index', 'store', 'show', 'update']);
  // 订单记录
  Route::apiResource('user_order', UserOrderController::class)->only(['index', 'show']);
  // 账单记录
  Route::apiResource('user_bill', UserBillController::class)->only(['index']);
  // 信息审核
  Route::apiResource('info_check', InfoCheckController::class)->only(['index', 'show', 'update']);
  // hr
  Route::post('hr_job/transfer', [HrJobController::class, 'transfer']);
  Route::post('hr_resume/transfer', [HrResumeController::class, 'transfer']);
  Route::apiResource('hr_job', HrJobController::class);
  Route::apiResource('hr_resume', HrResumeController::class);
  // 行业
  Route::get('industry/getParentTree', [IndustryController::class, 'getParentTree']);
  Route::apiResource('industry', IndustryController::class);
  // 任务
  Route::apiResource('task', TaskController::class)->only(['index', 'store', 'show', 'update']);
  Route::apiResource('task_rule', TaskRuleController::class)->only(['index', 'store', 'show', 'update']);
  // 信息投诉
  Route::apiResource('info_complaint', InfoComplaintController::class)->only(['index', 'show', 'update']);
  // 信息提供
  Route::apiResource('info_provide', InfoProvideController::class)->only(['index', 'show', 'store', 'update']);
  // 信息投递
  Route::apiResource('info_delivery', InfoDeliveryController::class)->only(['index']);
});
