<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Api\Traits\PayTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\HrJobRequest;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\InfoView;

class HrJobController extends Controller
{
  use PayTrait;
  /**
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(HrJobRequest $request)
  {
    $data = HrJob::aiQuery($request->input('industry'), $request->input('city'), $request->input('order'));
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $jobData = HrJob::findOrFail($id);
    $jobData->is_pay = $jobData->modelIsPay();
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

  /**
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function isComplaint(HrJobRequest $request)
  {
    $id = $request->input('id');
    $hrJobData = HrJob::findOrFail($id);
    $infoComplaintData = $hrJobData->modelGetComplaint();
    return $this->setParams($infoComplaintData)->success();
  }

  /**
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function complaint(HrJobRequest $request)
  {
    $id = $request->input('id');
    $hrJobData = HrJob::findOrFail($id);
    $infoComplaintData = $hrJobData->modelComplaint($request->only(['complaint_type', 'complaint_content']));
    return $this->setParams($infoComplaintData)->success('反馈成功');
  }
}
