<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserCouponRequest;
use App\Models\CouponTemplate;
use App\Models\User\UserCoupon;

class UserCouponController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = UserCoupon::with('user:id,nickname')->searchQuery()->orderByDesc('id')->pagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param UserCouponRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function store(UserCouponRequest $request)
  {
    $user_id = $request->input('user_id');
    $coupon_template_id = $request->input('coupon_template_id');
    $amount = $request->input('amount');
    $give_number = $request->input('give_number');
    $expiry_day = $request->input('expiry_day');

    $couponTemplateData = CouponTemplate::getCouponTemplateData($coupon_template_id);
    $couponTemplateData->giveCoupons($user_id, $give_number, $amount, $expiry_day, '后台赠送');

    return $this->success('赠送成功');
  }
}
