<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Info\InfoCheckRequest;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\InfoCheck;
use Illuminate\Support\Facades\DB;

class InfoCheckController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = InfoCheck::with('user:id,nickname')
      ->searchModel('info_checkable_type')
      ->where('status', InfoCheck::getStatusValue(1, '待审核'))
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = InfoCheck::findOrFail($id);
    return $this->setParams($data)->success();
  }

  /**
   * @param InfoCheckRequest $request
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function update(InfoCheckRequest $request, $id)
  {
    $infoCheckData = InfoCheck::findOrFail($id);
    $checkStatus = $request->input('status');
    $refuseReason = $request->input('refuse_reason');
    $contents = $request->input('contents');
    $infoCheckData->contents = $contents;
    $infoCheckData->save();

    // 如果未改变状态，直接返回
    if ($checkStatus === $infoCheckData->status) {
      return $this->success();
    }
    if ($infoCheckData->status !== InfoCheck::getStatusValue(1, '待审核')) {
      return $this->error('状态错误');
    }

    DB::beginTransaction();
    try {
      /**
       * @var HrJob $Model
       */
      $modelPath = $infoCheckData->info_checkable_type;
      $Model = new $modelPath();
      $input = $infoCheckData->contents;
      $input['user_id'] = $infoCheckData->user_id;
      $input['refuse_reason'] = $refuseReason;

      if ($checkStatus === InfoCheck::getStatusValue(2, '已通过')) {
        $id = $Model->checkInfoSuccess($input, $infoCheckData->info_checkable_id);
        $infoCheckData->info_checkable_id = $id;
      } else if ($checkStatus === InfoCheck::getStatusValue(3, '已拒绝')) {
        $infoCheckData->refuse_reason = $refuseReason;
        $Model->checkInfoFail($input, $infoCheckData->info_checkable_id);
      }
      $infoCheckData->status = $checkStatus;
      $infoCheckData->save();
      DB::commit();
      return $this->success();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().':'.__LINE__);
      return $this->error();
    }
  }
}
