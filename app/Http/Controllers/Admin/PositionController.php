<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PositionRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PositionController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = Role::where('guard_name', 'admin')
      ->where('name', '!=', 'root')
      ->get();
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
    $input['name'] = Str::random(10);
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
   * @throws \Exception
   */
  public function destroy($id)
  {
    $positionData = $this->getPosition($id);
    $positionData->delete();
    return $this->success();
  }

  /**
   * @param PositionRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function updatePermissions(PositionRequest $request, $id)
  {
    return $this->success();
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
