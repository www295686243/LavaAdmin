<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Models\Admin\User;
use Illuminate\Support\Arr;

class EmployeeController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = User::exceptRoot()
      ->with('roles')
      ->where('is_admin', 1)
      ->paginate();
    return $this->setParams($data)->success();
  }

  /**
   * @param EmployeeRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(EmployeeRequest $request)
  {
    $User = new User();
    $input = $request->only($User->getFillable());
    $input['is_admin'] = 1;
    $role_names = $request->input('role_names', []);
    $role_names = Arr::except($role_names, ['root']);
    $user = User::query()->create($input);
    $user->syncRoles($role_names);
    return $this->success();
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
   * @param EmployeeRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(EmployeeRequest $request, $id)
  {
    $User = new User();
    $input = $request->only($User->getFillable());
    $userData = $User->query()->findOrFail($id);
    $role_names = $request->input('role_names', []);
    $role_names = Arr::except($role_names, ['root']);
    if ($userData->hasRole('root') && !User::hasRoot()) {
      return $this->setStatusCode(423)->error('权限错误');
    }
    $userData->update($input);
    if (!$userData->hasRole('root')) {
      $userData->syncRoles($role_names);
    }
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
    if ($userData->hasRole('root')) {
      return $this->setStatusCode(423)->error('权限错误');
    }
    if (User::getUserId() === $userData->id) {
      return $this->setStatusCode(423)->error('权限错误');
    }
    $userData->delete();
    return $this->success();
  }
}
