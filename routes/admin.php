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
  Route::get('auth/getAppConfig', 'AuthController@getAppConfig');
  Route::middleware(['auth:sanctum', 'interface.permission'])->group(function () {
    Route::get('auth/getUserConfig', 'AuthController@getUserConfig');
    // 系统配置
    Route::apiResource('config', 'ConfigController');
    Route::apiResource('config_option', 'ConfigOptionController');
    // 后台日志
    Route::apiResource('admin_log', 'AdminLogController')->only(['index']);
    // 职位
    Route::get('position/getPermissions/{id}', 'PositionController@getPermissions');
    Route::post('position/updatePermissions/{id}', 'PositionController@updatePermissions');
    Route::apiResource('position', 'PositionController')->except(['destroy']);
    // 员工
    Route::apiResource('employee', 'EmployeeController');
    // 会员
    Route::apiResource('user', 'UserController');
    // 角色
    Route::get('role/getPermissions/{id}', 'RoleController@getPermissions');
    Route::post('role/updatePermissions/{id}', 'RoleController@updatePermissions');
    Route::apiResource('role', 'RoleController')->except(['destroy']);
    // 图片
    Route::post('image/destroyMore', 'ImageController@destroyMore');
    Route::apiResource('image', 'ImageController')->only(['index', 'store', 'destroy']);
    // 新闻
    Route::apiResource('news', 'NewsController');
    // 版本
    Route::apiResource('version', 'VersionController')->only(['index', 'update', 'show']);
  });
});