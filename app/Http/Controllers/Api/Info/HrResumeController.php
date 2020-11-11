<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Api\Traits\PayTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\HrResumeRequest;
use App\Models\Api\User;
use App\Models\Info\Hr\HrResume;
use App\Models\Info\InfoView;
use App\Models\User\UserOrder;

class HrResumeController extends Controller
{
  use PayTrait;
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = HrResume::pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $resumeData = HrResume::findOrFail($id);
    $resumeData->is_pay = $resumeData->user_order()
      ->where('user_id', User::getUserId())
      ->where('pay_status', UserOrder::getPayStatusValue(2, '已支付'))
      ->exists();
    if (!$resumeData->is_pay) {
      $resumeData->makeHidden(['contacts', 'phone']);
    }
    $resumeSubData = $resumeData->info_sub()->first();
    $resumeData->description = $resumeSubData->description;
    return $this->setParams($resumeData)->success();
  }

  /**
   * @param HrResumeRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function view(HrResumeRequest $request)
  {
    $id = $request->input('id');
    $hrJobData = HrResume::findOrFail($id);
    (new InfoView())->createView($request, $hrJobData);
    return $this->success();
  }
}
