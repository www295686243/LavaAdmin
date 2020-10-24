<?php

namespace App\Http\Controllers\Admin\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Coupon\CouponOrderSubRequest;
use App\Models\Coupon\CouponOrderSub;
use Illuminate\Http\Request;

class CouponOrderSubController extends Controller
{
  /**
   * @param CouponOrderSubRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(CouponOrderSubRequest $request)
  {
    $coupon_order_id = $request->input('coupon_order_id');
    $data = CouponOrderSub::with(['sell_user:id,nickname', 'buy_user:id,nickname', 'user_coupon:id,display_name,amount'])
      ->where('coupon_order_id', $coupon_order_id)
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }
}
