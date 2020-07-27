<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthRequest;
use App\Models\Admin\User;
use App\Models\Config;

class AuthController extends Controller
{
  /**
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

  /**
   * @param AuthRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getAppConfig(AuthRequest $request)
  {
    $guard_name = $request->input('guard_name');
    $data = Config::with('options')
      ->when($guard_name, function ($query, $guard_name) {
        return $query->where('guard_name', $guard_name);
      })
      ->get()
      ->groupBy('guard_name');
    return $this->setParams($data)->success();
  }
}
