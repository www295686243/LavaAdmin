<?php

namespace App\Http\Controllers\Admin\Coupon;

use App\Http\Controllers\Controller;
use App\Models\Coupon\CouponOrder;
use Illuminate\Http\Request;

class CouponOrderController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = CouponOrder::searchQuery()->with('user:id,nickname')
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }
}
