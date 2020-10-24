<?php

namespace App\Http\Controllers\Admin\Coupon;

use App\Http\Controllers\Controller;
use App\Models\Coupon\CouponMarket;
use Illuminate\Http\Request;

class CouponMarketController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = CouponMarket::searchQuery()
      ->with(['sell_user:id,nickname', 'buy_user:id,nickname', 'user_coupon:id,display_name'])
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }
}
