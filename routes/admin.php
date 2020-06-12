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
  Route::post('user/login', 'UserController@login');
  Route::middleware(['auth:sanctum', 'interface.permission'])->group(function () {
    Route::get('user/getUserConfig', 'UserController@getUserConfig');
    Route::apiResource('config', 'ConfigController');
    // 职位
    Route::get('position/getPermissions/{id}', 'PositionController@getPermissions');
    Route::post('position/updatePermissions/{id}', 'PositionController@updatePermissions');
    Route::apiResource('position', 'PositionController');
  });
});