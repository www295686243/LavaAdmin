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
   * @param HrResumeRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(HrResumeRequest $request)
  {
    $data = HrResume::aiQuery($request->input('industry'), $request->input('city'), $request->input('order'));
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
    $hrResumeData = HrResume::findOrFail($id);
    (new InfoView())->createView($request, $hrResumeData);
    return $this->success();
  }

  /**
   * @param HrResumeRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function isComplaint(HrResumeRequest $request)
  {
    $id = $request->input('id');
    $hrResumeData = HrResume::findOrFail($id);
    $infoComplaintData = $hrResumeData->modelGetComplaint();
    return $this->setParams($infoComplaintData)->success();
  }

  /**
   * @param HrResumeRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function complaint(HrResumeRequest $request)
  {
    $id = $request->input('id');
    $hrResumeData = HrResume::findOrFail($id);
    $infoComplaintData = $hrResumeData->modelComplaint($request->only(['complaint_type', 'complaint_content']));
    return $this->setParams($infoComplaintData)->success('反馈成功');
  }
}
