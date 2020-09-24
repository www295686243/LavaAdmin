<?php

namespace App\Http\Controllers\Api\User\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Info\HrResumeRequest;
use App\Models\Api\User;
use App\Models\Info\Hr\HrResume;
use App\Models\Info\InfoCheck;
use Illuminate\Http\Request;

class HrResumeController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = HrResume::where('user_id', User::getUserId())
      ->orderByDesc('id')
      ->simplePagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param HrResumeRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(HrResumeRequest $request)
  {
    $input = $request->getAll();
    $input['_type'] = HrResume::class;
    InfoCheck::createInfo($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = HrResume::findOrAuth($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    $data = HrResume::findOrAuth($id);
    return $data->delete() ? $this->success() : $this->error();
  }
}
