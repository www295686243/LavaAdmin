<?php

namespace App\Http\Controllers\Api\User\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Info\HrResumeRequest;
use App\Models\Api\User;
use App\Models\Info\Hr\HrResume;
use App\Models\Info\InfoCheck;
use App\Models\Notify\NotifyTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
  public function show(HrResumeRequest $request, $id)
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
}
