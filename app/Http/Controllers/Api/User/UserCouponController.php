<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserCouponRequest;
use App\Models\Api\User;
use App\Models\Coupon\CouponMarket;
use App\Models\User\UserCoupon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class UserCouponController extends Controller
{
  /**
   * @param UserCouponRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(UserCouponRequest $request)
  {
    $coupon_template_id = $request->input('coupon_template_id');
    $is_trade = $request->input('is_trade');
    $coupon_status = $request->input('coupon_status', UserCoupon::getCouponStatusValue(1, '未使用'));
    $data = UserCoupon::where('user_id', User::getUserId())
      ->when($coupon_template_id, function (Builder $query, $coupon_template_id) {
        return $query->where('coupon_template_id', $coupon_template_id);
      })
      ->when($is_trade !== null, function (Builder $query, $is_trade) {
        return $query->where('is_trade', $is_trade);
      })
      ->where('coupon_status', $coupon_status)
      ->orderByDesc('id')
      ->simplePagination();
    return $this->setParams($data)->success();
  }

  /**
   * @param UserCouponRequest $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Throwable
   */
  public function recall(UserCouponRequest $request)
  {
    $user_coupon_ids = $request->input('user_coupon_ids');
    $userCouponQuery = UserCoupon::whereIn('id', $user_coupon_ids)
      ->where('user_id', User::getUserId())
      ->where('coupon_status', UserCoupon::getCouponStatusValue(4, '挂售中'));
    $userCouponCount = $userCouponQuery->count();
    if ($userCouponCount !== count($user_coupon_ids)) {
      return $this->error('通用券状态错误，请刷新后再试');
    }

    $couponMarketQuery = CouponMarket::whereIn('user_coupon_id', $user_coupon_ids)
      ->where('sell_user_id', User::getUserId())
      ->where('status', CouponMarket::getStatusValue(1, '出售中'));
    $couponMarketCount = $couponMarketQuery->count();
    if ($couponMarketCount !== count($user_coupon_ids)) {
      return $this->error('市场通用券状态错误，请刷新后再试');
    }

    DB::beginTransaction();
    try {
      $couponMarketQuery->update(['status' => CouponMarket::getStatusValue(5, '已撤回')]);
      $userCouponQuery->update(['coupon_status' => UserCoupon::getCouponStatusValue(1, '未使用')]);
      DB::commit();
      return $this->success('撤回成功');
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage());
      return $this->error('撤回失败');
    }
  }
}
