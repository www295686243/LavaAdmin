<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Api\Traits\PayTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\HrJobRequest;
use App\Models\Api\User;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\InfoCheck;
use App\Models\Info\InfoView;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\UserCoupon;
use Illuminate\Support\Facades\DB;

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
   * @return \Illuminate\Http\JsonResponse
   */
  public function authIndex()
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
    $checkData = InfoCheck::createInfo($input);
    NotifyTemplate::sendAdmin(25, '运营管理员审核信息通知', [
      'id' => $checkData->id,
      'title' => $input['title'],
      'contacts' => $input['contacts'].'/'.$input['phone'],
      'description' => $input['description'],
      'created_at' => $checkData->created_at->format('Y-m-d H:i:s'),
      '_model' => 'Info/Hr/HrJob,Info/Hr/HrResume'
    ]);
    return $this->success();
  }

  /**
   * @param HrJobRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function authShow(HrJobRequest $request, $id)
  {
    $check = $request->input('_check');
    if ($check) {
      $infoCheckData = InfoCheck::findOrAuth($id);
      $data = $infoCheckData->contents;
    } else {
      $data = HrJob::findOrAuth($id);
      $subData = $data->info_sub()->first();
      $data->description = $subData->description;
    }
    return $this->setParams($data)->success();
  }

  /**
   * @param HrJobRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(HrJobRequest $request, $id)
  {
    $check = $request->input('_check');
    $input = $request->getAll();
    if ($check) {
      InfoCheck::updateInfo($input, $id);
    } else {
      $input['_model'] = HrJob::class;
      InfoCheck::createInfo($input);
    }
    return $this->success('职位已提交成功，请等待管理员审核!');
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

  /**
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateDisable(HrJobRequest $request)
  {
    $id = $request->input('id');
    $data = HrJob::findOrAuth($id);
    if (!($data->status === HrJob::getStatusValue(1, '已发布') || $data->status === HrJob::getStatusValue(3, '已下架'))) {
      return $this->error('状态错误');
    }
    $data->status = $data->status === HrJob::getStatusValue(3, '已下架') ? HrJob::getStatusValue(1, '已发布') : HrJob::getStatusValue(3, '已下架');
    return $data->save() ? $this->setParams(['status' => $data->status])->success($data->status === HrJob::getStatusValue(1, '已发布') ? '上架成功': '下架成功') : $this->error();
  }

  /**
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function refreshUpdateAt(HrJobRequest $request)
  {
    $id = $request->input('id');
    $Job = HrJob::findOrAuth($id);
    $Job->refresh_at = date('Y-m-d H:i:s');
    $Job->save();
    return $this->success('刷新成功');
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

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function getUsableCoupon()
  {
    $data = UserCoupon::where('user_id', User::getUserId())
      ->where('coupon_status', UserCoupon::getCouponStatusValue(1, '未使用'))
      ->whereIn('coupon_template_id', [1, 3])
      ->orderBy('is_trade', 'asc')
      ->simplePagination();
    return $this->setParams($data)->success();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function checkIndex()
  {
    $data = InfoCheck::getList(HrJob::class);
    return $this->setParams($data)->success();
  }

  /**
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function pay(HrJobRequest $request)
  {
    $id = $request->input('id');
    $hrJobData = HrJob::findOrFail($id);

    return $this->_pay($hrJobData);
  }

  /**
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getContacts(HrJobRequest $request)
  {
    $id = $request->input('id');
    $hrJobData = HrJob::findOrFail($id);
    $data = $hrJobData->modelGetContacts();
    return $this->setParams($data)->success();
  }

  /**
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function recommendList(HrJobRequest $request)
  {
    $id = $request->input('id');
    $hrJobData = HrJob::findOrFail($id);
    $data = $hrJobData->modelGetRecommendList();
    return $this->setParams($data)->success();
  }
}
