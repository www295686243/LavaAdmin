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
      ->searchType()
      ->where('status', InfoCheck::getOptionsValue(47, '待审核'))
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

    DB::beginTransaction();
    try {
      if ($checkStatus === InfoCheck::getOptionsValue(48, '已审核')) {
        if ($infoCheckData->status === $checkStatus) {
          return $this->error('状态错误');
        }
        /**
         * @var HrJob $Model
         */
        $modelPath = $infoCheckData->info_checkable_type;
        $Model = new $modelPath();
        $id = $Model->createOrUpdateData($infoCheckData->contents, $infoCheckData->info_checkable_id);
        $infoCheckData->info_checkable_id = $id;
      } else if ($checkStatus === InfoCheck::getOptionsValue(49, '已拒绝')) {
        $infoCheckData->refuse_reason = $refuseReason;
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
