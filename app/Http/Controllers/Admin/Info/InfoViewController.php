<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfoViewController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $share_user_id = request()->input('share_user_id');
    $infoData = $this->getModelData();
    $data = $infoData->info_view()
      ->with('user:id,nickname')
      ->when($share_user_id, function ($query) use ($share_user_id) {
        return $query->where('share_user_id', $share_user_id);
      })
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }
}
