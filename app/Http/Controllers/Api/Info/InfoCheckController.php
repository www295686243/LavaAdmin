<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Info\InfoCheckRequest;
use App\Models\Api\User;
use App\Models\Info\InfoCheck;
use Illuminate\Http\Request;

class InfoCheckController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = InfoCheck::select(['id', 'user_id', 'info_title', 'status', 'refuse_reason', 'created_at'])
      ->where('user_id', User::getUserId())
      ->where('info_checkable_type', $this->getModelPath())
      ->where('status', '!=', InfoCheck::getOptionsValue(48, '已审核'))
      ->orderByDesc('id')
      ->get();
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    $data = InfoCheck::findOrAuth($id);
    return $data->delete() ? $this->success() : $this->error();
  }
}