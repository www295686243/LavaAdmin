<?php

namespace App\Http\Controllers\Api\User\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Info\HrJobRequest;
use App\Models\Api\User;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\InfoCheck;
use Illuminate\Http\Request;

class HrJobController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = HrJob::where('user_id', User::getUserId())
      ->orderByDesc('id')
      ->simplePagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(HrJobRequest $request)
  {
    $input = $request->getAll();
    $input['_model'] = HrJob::class;
    InfoCheck::createInfo($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = HrJob::findOrAuth($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    $data = HrJob::findOrAuth($id);
    return $data->delete() ? $this->success() : $this->error();
  }
}
