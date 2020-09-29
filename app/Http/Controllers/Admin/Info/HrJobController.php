<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Info\HrJobRequest;
use App\Models\Admin\User;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\InfoSub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HrJobController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = HrJob::searchQuery()->with(['user:id,nickname', 'admin_user:id,nickname'])
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function store(HrJobRequest $request)
  {
    $input = $request->all();
    $input['user_id'] = User::getUserId();
    $input['admin_user_id'] = User::getUserId();
    (new HrJob())->createOrUpdateData($input);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = HrJob::findOrAuth($id);
    $data->industry;
    $subData = $data->info_sub()->firstOrFail();
    $data = array_merge($data->toArray(), $subData->toArray());
    return $this->setParams($data)->success();
  }

  /**
   * @param HrJobRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function update(HrJobRequest $request, $id)
  {
    $input = $request->all();
    (new HrJob())->createOrUpdateData($input, $id);
    return $this->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function destroy($id)
  {
    $data = HrJob::findOrAuth($id);
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
   * @param HrJobRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function transfer(HrJobRequest $request)
  {
    $id = $request->input('info_id');
    $transfer_user_id = $request->input('transfer_user_id');
    $userData = \App\Models\Api\User::find($transfer_user_id);
    if (!$userData) {
      return $this->error('该用户不存在');
    }
    $Job = HrJob::findOrFail($id);
    $Job->user_id = $transfer_user_id;
    $Job->save();
    return $this->success();
  }
}
