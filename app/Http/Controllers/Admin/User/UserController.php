<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Api\User;

class UserController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = User::searchQuery()
      ->with('roles')
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = User::with('roles')->findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param UserRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UserRequest $request, $id)
  {
    $input = $request->only((new User())->getFillable());
    $userData = User::findOrFail($id);
    $userData->update($input);
    // 更新角色
    $role_names = $request->input('role_names', []);
    $userData->syncRoles($role_names);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function destroy($id)
  {
    $userData = User::findOrFail($id);
    $userData->delete();
    return $this->success();
  }
}
