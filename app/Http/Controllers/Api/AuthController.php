<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Models\Api\User;
use App\Models\Config;
use Illuminate\Http\Request;

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
    $userData = (new User())->getToken($username, $password);
    return $this->setParams($userData)->success();
  }
}
