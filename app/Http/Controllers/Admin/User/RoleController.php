<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\User\User;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = Role::where('guard_name', 'api')->get();
    return $this->setParams($data)->success();
  }

  /**
   * @param RoleRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(RoleRequest $request)
  {
    $Role = new Role();
    $input = $request->only($Role->getFillable());
    $input['name'] = Str::random(10);
    $input['guard_name'] = 'api';
    $Role->create($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = Role::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param RoleRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(RoleRequest $request, $id)
  {
    $input = $request->only(['display_name']);
    $roleData = Role::findOrFail($id);
    $roleData->update($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function getPermissions($id)
  {
    $roleData = Role::findOrFail($id);
    $userData = User::getUserData();
    return $this->setParams([
      'interface' => $userData->getAssignInterfaceTree('api'),
      'interface_permissions' => $roleData->getAllPermissions()->pluck('name')
    ])->success();
  }

  /**
   * @param RoleRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function updatePermissions(RoleRequest $request, $id)
  {
    $permissions = $request->input('permissions', []);
    $userData = User::getUserData();
    if (!$userData->checkAssignInterface($permissions, 'api')) {
      return $this->setStatusCode(423)->error('权限错误');
    }
    $roleData = Role::findOrFail($id);
    $roleData->syncPermissions($permissions);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function getAssignPermissions($id)
  {
    $roleData = Role::findOrFail($id);
    return $this->setParams([
      'interface' => Permission::getAllPermissionTree('api'),
      'interface_permissions' => $roleData->assign_api_interface ?? []
    ])->success();
  }

  /**
   * @param RoleRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateAssignPermissions(RoleRequest $request, $id)
  {
    $permissions = $request->input('permissions', []);
    $roleData = Role::findOrFail($id);
    $roleData->assign_api_interface = $permissions;
    $roleData->save();
    return $this->success();
  }
}
