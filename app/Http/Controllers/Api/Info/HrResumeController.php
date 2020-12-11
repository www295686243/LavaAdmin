<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Api\Traits\PayTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\HrResumeRequest;
use App\Models\Api\User;
use App\Models\Info\Hr\HrResume;
use App\Models\Info\InfoCheck;
use App\Models\Info\InfoView;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\UserCoupon;
use Illuminate\Support\Facades\DB;

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
    $resumeData->is_pay = $resumeData->modelIsPay();
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
   * @return \Illuminate\Http\JsonResponse
   */
  public function authIndex()
  {
    $data = HrResume::where('user_id', User::getUserId())
      ->orderByDesc('id')
      ->simplePagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param HrResumeRequest $request
   * @return mixed
   * @throws \Throwable
   */
  public function store(HrResumeRequest $request)
  {
    $input = $request->getAll();
    $input['_model'] = HrResume::class;
    return DB::transaction(function () use ($input) {
      $checkData = InfoCheck::createInfo($input);
      NotifyTemplate::sendAdmin(25, '运营管理员审核信息通知', [
        'id' => $checkData->id,
        'title' => $input['title'],
        'contacts' => $input['contacts'].'/'.$input['phone'],
        'description' => $input['description'],
        'created_at' => $checkData->created_at->format('Y-m-d H:i:s'),
        '_model' => 'Info/Hr/HrJob,Info/Hr/HrResume'
      ]);
      return $this->success('简历已提交成功，请等待管理员审核!');
    });

  }

  /**
   * @param HrResumeRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function authShow(HrResumeRequest $request, $id)
  {
    $check = $request->input('_check');
    if ($check) {
      $infoCheckData = InfoCheck::findOrAuth($id);
      $data = $infoCheckData->contents;
    } else {
      $data = HrResume::findOrAuth($id);
      $subData = $data->info_sub()->first();
      $data->description = $subData->description;
    }
    return $this->setParams($data)->success();
  }

  /**
   * @param HrResumeRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(HrResumeRequest $request, $id)
  {
    $check = $request->input('_check');
    $input = $request->getAll();
    if ($check) {
      InfoCheck::updateInfo($input, $id);
    } else {
      $input['_model'] = HrResume::class;
      InfoCheck::createInfo($input);
    }
    return $this->success('简历已提交成功，请等待管理员审核!');
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

  /**
   * @param HrResumeRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateDisable(HrResumeRequest $request)
  {
    $id = $request->input('id');
    $data = HrResume::findOrAuth($id);
    if (!($data->status === HrResume::getStatusValue(1, '已发布') || $data->status === HrResume::getStatusValue(3, '已下架'))) {
      return $this->error('状态错误');
    }
    $data->status = $data->status === HrResume::getStatusValue(3, '已下架') ? HrResume::getStatusValue(1, '已发布') : HrResume::getStatusValue(3, '已下架');
    return $data->save() ? $this->setParams(['status' => $data->status])->success($data->status === HrResume::getStatusValue(1, '已发布') ? '上架成功': '下架成功') : $this->error();
  }

  /**
   * @param HrResumeRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function refreshUpdateAt(HrResumeRequest $request)
  {
    $id = $request->input('id');
    $Job = HrResume::findOrAuth($id);
    $Job->refresh_at = date('Y-m-d H:i:s');
    $Job->save();
    return $this->success('刷新成功');
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
   * @return mixed
   * @throws \Throwable
   */
  public function complaint(HrResumeRequest $request)
  {
    $id = $request->input('id');
    $hrResumeData = HrResume::findOrFail($id);
    return DB::transaction(function () use ($hrResumeData, $request) {
      $infoComplaintData = $hrResumeData->modelComplaint($request->only(['complaint_type', 'complaint_content']));
      return $this->setParams($infoComplaintData)->success('反馈成功');
    });
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function getUsableCoupon()
  {
    $data = UserCoupon::where('user_id', User::getUserId())
      ->where('coupon_status', UserCoupon::getCouponStatusValue(1, '未使用'))
      ->whereIn('coupon_template_id', [2, 3])
      ->orderBy('is_trade', 'asc')
      ->simplePagination();
    return $this->setParams($data)->success();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function checkIndex()
  {
    $data = InfoCheck::getList(HrResume::class);
    return $this->setParams($data)->success();
  }

  /**
   * @param HrResumeRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function pay(HrResumeRequest $request)
  {
    $id = $request->input('id');
    $hrResumeData = HrResume::findOrFail($id);

    return $this->_pay($hrResumeData);
  }

  /**
   * @param HrResumeRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getContacts(HrResumeRequest $request)
  {
    $id = $request->input('id');
    $hrResumeData = HrResume::findOrFail($id);
    $data = $hrResumeData->modelGetContacts();
    return $this->setParams($data)->success();
  }

  /**
   * @param HrResumeRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function recommendList(HrResumeRequest $request)
  {
    $id = $request->input('id');
    $hrJobData = HrResume::findOrFail($id);
    $data = $hrJobData->modelGetRecommendList();
    return $this->setParams($data)->success();
  }
}
