<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User\UserOrder;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = UserOrder::searchQuery()->with(['user', 'user_coupon', 'user_orderable'])->orderByDesc('id')->pagination();
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
