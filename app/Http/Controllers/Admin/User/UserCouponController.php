<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserCouponRequest;
use App\Models\Coupon\CouponTemplate;
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
    $rewards = $request->input('rewards');
    CouponTemplate::giveManyCoupons($user_id, $rewards, '后台赠送');
    return $this->success('赠送成功');
  }
}
