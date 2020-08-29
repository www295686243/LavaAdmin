<?php

namespace App\Models\User;

use App\Models\Base;
use App\Models\ConfigOption;
use Kra8\Snowflake\HasSnowflakePrimary;

class UserCoupon extends Base
{
  use HasSnowflakePrimary;
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
    'end_at' => 'datetime:Y-m-d H:i'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @param $coupon_id
   * @return UserCoupon|UserCoupon[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
   */
  public function getUsableCoupon($coupon_id)
  {
    $userCouponData = self::findOrFail($coupon_id);
    $userCouponData->checkExpired();
    $userCouponData->coupon_status = (new ConfigOption())->getOperationValue('coupon_status', '已使用');
    $userCouponData->save();
    return $userCouponData;
  }

  /**
   * @return bool
   */
  private function checkExpired()
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
}
