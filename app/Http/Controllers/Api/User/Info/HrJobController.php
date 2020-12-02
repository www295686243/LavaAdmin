<?php

namespace App\Http\Controllers\Api\User\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Info\HrJobRequest;
use App\Models\Api\User;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\InfoCheck;
use App\Models\Notify\NotifyTemplate;
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
  public function show(HrJobRequest $request, $id)
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
}
