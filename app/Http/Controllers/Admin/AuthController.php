<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthRequest;
use App\Models\Admin\User;
use App\Models\Config;

class AuthController extends Controller
{
  /**
   * 第三方登陆
   * @param AuthRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(AuthRequest $request)
  {
    $username = $request->input('username');
    $password = $request->input('password');
    $userData = (new User())->getToken($username, $password, true);
    return $this->setParams($userData)->success();
  }

  /**
   * 只为了登陆埋点
   * @return \Illuminate\Http\JsonResponse
   */
  public function loginStat()
  {
    return $this->success('登陆成功');
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function getUserConfig()
  {
    $userData = User::getUserData();
    return $this->setParams([
      'user' => $userData,
      'menus' => $userData->getMenuPermissions(),
      'interface' => $userData->getInterfacePermissions()
    ])->success();
  }
}
