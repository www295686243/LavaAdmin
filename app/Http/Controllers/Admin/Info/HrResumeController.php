<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Info\HrResumeRequest;
use App\Models\Admin\User;
use App\Models\Info\Hr\HrResume;
use App\Models\Info\InfoSub;
use Illuminate\Support\Facades\DB;

class HrResumeController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = HrResume::searchQuery()->with(['user:id,nickname', 'admin_user:id,nickname'])
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param HrResumeRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function store(HrResumeRequest $request)
  {
    $input = $request->all();
    $input['user_id'] = User::getUserId();
    $input['admin_user_id'] = User::getUserId();
    (new HrResume())->createOrUpdateData($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = HrResume::findOrAuth($id);
    $data->industry;
    $subData = $data->info_sub()->firstOrFail();
    $data = array_merge($data->toArray(), $subData->toArray());
    return $this->setParams($data)->success();
  }

  /**
   * @param HrResumeRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function update(HrResumeRequest $request, $id)
  {
    $input = $request->all();
    (new HrResume())->createOrUpdateData($input, $id);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function destroy($id)
  {
    $data = HrResume::findOrAuth($id);
    DB::beginTransaction();
    try {
      $data->info_sub()->delete();
//      $data->industry()->detach(); 信息是软删除的 这里会删数据，先注释掉 等需要从行业反向查询信息的时候看怎么弄
      $data->delete();
      DB::commit();
      return $this->success();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().':'.__LINE__);
      return $this->error();
    }
  }

  /**
   * @param HrResumeRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function transfer(HrResumeRequest $request)
  {
    $id = $request->input('id');
    $transfer_user_id = $request->input('transfer_user_id');
    $userData = \App\Models\Api\User::find($transfer_user_id);
    if (!$userData) {
      return $this->error('该用户不存在');
    }
    $Job = HrResume::findOrFail($id);
    $Job->user_id = $transfer_user_id;
    $Job->save();
    return $this->success();
  }
}
