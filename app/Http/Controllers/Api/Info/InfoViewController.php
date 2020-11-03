<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\InfoViewRequest;
use App\Models\Api\User;
use App\Models\Info\InfoView;
use Illuminate\Support\Facades\DB;

class InfoViewController extends Controller
{
  /**
   * 记录查看人，并处理分享逻辑(在Task中间件)
   * @param InfoViewRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function store(InfoViewRequest $request)
  {
    $user_id = User::getUserId();
    $infoData = $this->getModelData();
    $share_user_id = $request->input('su');
    if ($share_user_id) {
      $isExists = $infoData->info_view()
        ->where('user_id', $user_id)
        ->where('share_user_id', $user_id)
        ->exists();
    } else {
      $isExists = $infoData->info_view()->where('user_id', $user_id)->exists();
    }
    $isAllExists = InfoView::where('user_id', $user_id)->exists();
    if ($infoData->user_id !== $user_id) {
      DB::beginTransaction();
      try {
        if (!$isExists) {
          $infoData->info_view()->create([
            'share_user_id' => $share_user_id,
            'user_id' => $user_id,
            'is_new_user' => !$isAllExists
          ]);
        }
        $infoData->views += 1;
        $infoData->save();
        DB::commit();
      } catch (\Exception $e) {
        DB::rollBack();
        \Log::error($e->getMessage());
        return $this->error('访问失败');
      }
    }
    return $this->success();
  }
}
