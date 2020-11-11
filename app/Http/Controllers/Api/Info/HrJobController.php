<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Api\Traits\PayTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\HrJobRequest;
use App\Models\Api\User;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\InfoView;
use App\Models\User\UserOrder;

class HrJobController extends Controller
{
  use PayTrait;
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = HrJob::pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $jobData = HrJob::findOrFail($id);
    $jobData->is_pay = $jobData->user_order()
      ->where('user_id', User::getUserId())
      ->where('pay_status', UserOrder::getPayStatusValue(2, '已支付'))
      ->exists();
    if (!$jobData->is_pay) {
      $jobData->makeHidden(['contacts', 'phone']);
    }
    $jobSubData = $jobData->info_sub()->first();
    $jobData->description = $jobSubData->description;
    return $this->setParams($jobData)->success();
  }

  /**
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function view(HrJobRequest $request)
  {
    $id = $request->input('id');
    $hrJobData = HrJob::findOrFail($id);
    (new InfoView())->createView($request, $hrJobData);
    return $this->success();
  }
}
