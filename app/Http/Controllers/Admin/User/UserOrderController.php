<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User\UserOrder;

class UserOrderController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = UserOrder::searchQuery()
      ->with(['user:id,nickname', 'user_coupon:id,display_name', 'user_orderable'])
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
    $data = UserOrder::with(['user', 'user_coupon', 'user_orderable'])->findOrFail($id);
    return $this->setParams($data)->success();
  }
}
