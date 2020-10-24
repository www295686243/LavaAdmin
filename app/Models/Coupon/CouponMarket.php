<?php

namespace App\Models\Coupon;

use App\Models\Base;
use App\Models\User\User;
use App\Models\User\UserCoupon;

class CouponMarket extends Base
{
  protected $fillable = [
    'sell_user_id',
    'buy_user_id',
    'user_coupon_id',
    'coupon_template_id',
    'amount',
    'amount_sort',
    'status',
    'end_at'
  ];

  protected $casts = [
    'amount' => 'float',
    'end_at' => 'datetime:Y-m-d H:i'
  ];

  public function setAmountSortAttribute()
  {
    $this->attributes['amount_sort'] = intval($this->attributes['amount'] * 100);
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

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user_coupon()
  {
    return $this->belongsTo(UserCoupon::class);
  }
}
