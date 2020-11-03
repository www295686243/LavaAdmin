<?php

namespace App\Http\Controllers\Admin\Info;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class InfoViewController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $share_user_id = request()->input('share_user_id');
    $is_new_user = request()->input('is_new_user');
    $infoData = $this->getModelData();
    $data = $infoData->info_view()
      ->with('user:id,nickname')
      ->when($share_user_id, function (Builder $query, $share_user_id) {
        return $query->where('share_user_id', $share_user_id);
      })
      ->when($is_new_user, function (Builder $query, $is_new_user) {
        return $query->where('is_new_user', $is_new_user);
      })
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }
}
