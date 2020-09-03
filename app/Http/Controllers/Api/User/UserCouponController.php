<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\ConfigOption;
use App\Models\User\UserCoupon;

class UserCouponController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = UserCoupon::where('coupon_status', UserCoupon::getOptionsValue('coupon_status', '未使用'))->pagination();
    return $this->setParams($data)->success();
  }
}
