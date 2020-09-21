<?php

namespace App\Http\Controllers\Api\User\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\HrRequest;
use App\Models\Api\User;
use App\Models\Info\Hr;
use App\Models\Info\InfoCheck;

class HrController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = Hr::where('user_id', User::getUserId())
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param HrRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(HrRequest $request)
  {
    $input = $request->getAll();
    $input['_type'] = $this->getModelPath('Info/Hr');
    InfoCheck::createInfo($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = Hr::findOrAuth($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    $data = Hr::findOrAuth($id);
    return $data->delete() ? $this->success() : $this->error();
  }
}
