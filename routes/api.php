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
  Route::post('auth/login', 'AuthController@login');
  Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/getUserConfig', 'UserController@getUserConfig');
    Route::post('user/sendSmsCaptcha', 'UserController@sendSmsCaptcha');
    Route::post('user/bindPhone', 'UserController@bindPhone');
    Route::post('user/verifyPhone', 'UserController@verifyPhone');
  });
});