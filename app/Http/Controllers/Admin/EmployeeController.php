<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Models\Admin\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param EmployeeRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function store(EmployeeRequest $request)
  {
    return DB::transaction(function () use ($request) {
      $input = $request->all();
      $input['is_admin'] = 1;
      $userData = User::createUser($input);
      $role_names = $request->input('role_names', []);
      $role_names = Arr::except($role_names, ['root']);
      $userData->syncRoles($role_names);
      return $this->success();
    });
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
   * @throws \Throwable
   */
  public function update(EmployeeRequest $request, $id)
  {
    return DB::transaction(function () use ($request, $id) {
      $input = $request->all();
      $userData = User::updateUser($input, $id);

      $role_names = $request->input('role_names', []);
      $role_names = Arr::except($role_names, ['root']);
      if ($userData->hasRole('root') && !$userData->hasRoot()) {
        return $this->setStatusCode(423)->error('权限错误');
      }
      if (!$userData->hasRole('root')) {
        $userData->syncRoles($role_names);
      }
      return $this->success();
    });
  }

  /**
   * @param $id
   * @return mixed
   * @throws \Throwable
   */
  public function destroy($id)
  {
    return DB::transaction(function () use ($id) {
      $userData = User::destroyUser($id);
      if ($userData->hasRole('root')) {
        return $this->setStatusCode(423)->error('权限错误');
      }
      if (User::getUserId() === $userData->id) {
        return $this->setStatusCode(423)->error('权限错误');
      }
      return $this->success();
    });
  }
}
