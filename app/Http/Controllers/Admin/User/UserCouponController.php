<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserCouponRequest;
use App\Models\Coupon\CouponTemplate;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\UserCoupon;
use Illuminate\Support\Facades\DB;

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
   * @return mixed
   * @throws \Throwable
   */
  public function store(UserCouponRequest $request)
  {
    $user_id = $request->input('user_id');
    $rewards = $request->input('rewards');
    return DB::transaction(function () use ($user_id, $rewards) {
      $giveCouponsText = CouponTemplate::giveManyCoupons($user_id, $rewards, '后台赠送');
      NotifyTemplate::sendGiveCoupon(32, '管理员赠送互助券成功通知', $user_id, [
        'giveCouponsText' => $giveCouponsText
      ]);
      return $this->success('赠送成功');
    });
  }
}
