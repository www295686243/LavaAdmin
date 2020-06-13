<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Admin\User;

class AuthController extends Controller
{
  /**
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(UserRequest $request)
  {
    $username = $request->input('username');
    $password = $request->input('password');
    $userData = (new User())->getToken($username, $password);
    if ($userData->is_admin === 0) {
      return $this->error('您不是后台管理员');
    }
    return $this->setParams($userData)->success();
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
