<?php

namespace App\Models\User;

use App\Models\Base\Base;

class UserCoupon extends Base
{
  protected $fillable = [
    'coupon_template_id',
    'user_id',
    'display_name',
    'desc',
    'amount',
    'coupon_status',
    'start_at',
    'end_at',
    'source',
    'is_trade'
  ];

  protected $casts = [
    'amount' => 'float',
    'end_at' => 'datetime:Y-m-d H:i',
    'coupon_template_id' => 'string'
  ];

  protected $appends = [
    'active'
  ];

  /**
   * @return bool
   */
  public function getActiveAttribute()
  {
    return false;
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @param $user_coupon_id
   * @return float
   */
  public function getUsableCouponAmount($user_coupon_id)
  {
    $userCouponData = null;
    if ($user_coupon_id) {
      $userCouponData = self::findOrFail($user_coupon_id);
      if ($userCouponData->coupon_status === UserCoupon::getCouponStatusValue(2, '已使用')) {
        $this->error('优惠券状态错误!');
      }
      $userCouponData->checkExpired();
      $userCouponData->coupon_status = UserCoupon::getCouponStatusValue(2, '已使用');
      $userCouponData->save();
    }
    return optional($userCouponData)->amount ?? 0;
  }

  /**
   * @return bool
   */
  public function checkExpired()
  {
    $currentDate = date('Y-m-d H:i:s');
    if ($this->start_at > $currentDate) {
      $this->error('该优惠券未到使用日期');
    }
    if ($currentDate > $this->end_at) {
      $this->error('该优惠券已过期');
    }
    return true;
  }

  /**
   * @param $value
   * @param $display_name
   * @return int
   */
  public static function getCouponStatusValue($value, $display_name)
  {
    return static::getOptionsValue('coupon_status', $value, $display_name);
  }
}
