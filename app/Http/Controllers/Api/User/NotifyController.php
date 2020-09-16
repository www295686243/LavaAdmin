<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Api\User;
use App\Models\Notify\Notify;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = Notify::where('user_id', User::getUserId())
      ->where('is_push_message', 1)
      ->orderByDesc('id')
      ->simplePagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {
    $data = Notify::findOrFail($id);
    $data->is_read = 1;
    $data->save();
    return $this->success();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function getUnreadCount()
  {
    $count = Notify::where('user_id', User::getUserId())
      ->where('is_push_message', 1)
      ->where('is_read', 0)
      ->count();
    return $this->setParams(['count' => $count])->success();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function markHaveRead()
  {
    Notify::where('user_id', User::getUserId())
    ->where('is_push_message', 1)
    ->where('is_read', 0)
    ->update(['is_read' => 1]);
    return $this->success();
  }
}
