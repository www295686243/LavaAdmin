<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;

class UserController extends Controller
{
  /**
   * @param UserRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(UserRequest $request)
  {
    $username = $request->input('username');
    $password = $request->input('password');
    $data = (new User())->getToken($username, $password);
    return $this->setParams($data)->success();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function getUserInfo()
  {
    $data = auth()->user();
    return $this->setParams($data)->success();
  }
}
