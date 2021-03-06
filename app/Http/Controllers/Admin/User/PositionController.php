<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PositionRequest;
use App\Models\User\User;
use App\Models\AdminMenu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PositionController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $userData = User::getUserData();
    if ($userData->hasRoot()) {
      $roleData = Role::findOrFail(1);
      $data = $roleData->descendants()->get()->toTree();
    } else {
      $data = $userData->roles()->get()->map(function ($roleData) {
        return $roleData->descendants()->get()->toTree();
      })->flatten()->toArray();
    }
    return $this->setParams($data)->success();
  }

  /**
   * @param PositionRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(PositionRequest $request)
  {
    $Position = new Role();
    $input = $request->only($Position->getFillable());
    $input['platform'] = 'admin';
    $Position->create($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = $this->getPosition($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param PositionRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(PositionRequest $request, $id)
  {
    $input = $request->only(['display_name']);
    $positionData = $this->getPosition($id);
    $positionData->update($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function getPermissions($id)
  {
    $positionData = Role::findOrFail($id);
    $userData = User::getUserData();
    return $this->setParams([
      'menus' => $userData->getAssignMenuTree(),
      'menu_permissions' => $positionData->menu_permissions ?? [],
      'interface' => $userData->getAssignInterfaceTree('admin'),
      'interface_permissions' => $positionData->getAllPermissions()->pluck('name')
    ])->success();
  }

  /**
   * @param PositionRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse|mixed
   * @throws \Throwable
   */
  public function updatePermissions(PositionRequest $request, $id)
  {
    $menus = $request->input('menus', []);
    $permissions = $request->input('permissions', []);
    $userData = User::getUserData();
    if (!$userData->checkAssignMenu($menus) || !$userData->checkAssignInterface($permissions)) {
      return $this->setStatusCode(423)->error('权限错误');
    }
    $positionData = Role::findOrFail($id);

    return DB::transaction(function () use ($positionData, $menus, $permissions) {
      $positionData->menu_permissions = $menus;
      $positionData->save();
      $positionData->syncPermissions($permissions);
      return $this->success();
    });
  }

  /**
   * @param $id
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
   */
  private function getPosition($id)
  {
    return Role::where('id', $id)->where('name', '!=', 'root')->firstOrFail();
  }
}
