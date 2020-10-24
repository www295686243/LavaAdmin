<?php

namespace App\Models\Coupon;

use App\Models\Base;
use App\Models\User\User;
use App\Models\User\UserCoupon;

class CouponOrderSub extends Base
{
  protected $fillable = [
    'sell_user_id',
    'buy_user_id',
    'coupon_order_id',
    'user_coupon_id',
    'coupon_market_id',
    'amount'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user_coupon()
  {
    return $this->belongsTo(UserCoupon::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function sell_user()
  {
    return $this->belongsTo(User::class, 'sell_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function buy_user()
  {
    return $this->belongsTo(User::class, 'buy_user_id');
  }
}
