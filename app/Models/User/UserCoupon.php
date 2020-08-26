<?php

namespace App\Models\User;

use App\Models\Base;

class UserCoupon extends Base
{
  protected $fillable = [
    'coupon_template_id',
    'user_id',
    'display_name',
    'desc',
    'amount',
    'status',
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
}
