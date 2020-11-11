<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Api\User;
use App\Models\User\UserOrder;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = UserOrder::with('user_orderable:id,title,contacts,status')
      ->where('user_id', User::getUserId())
      ->where('pay_status', UserOrder::getPayStatusValue(2, '已支付'))
      ->where('paid_at', '>', date('Y-m-d H:i:s', strtotime('-7 day')))
      ->simplePagination();
    return $this->setParams($data)->success();
  }
}
