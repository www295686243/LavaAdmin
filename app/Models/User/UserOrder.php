<?php

namespace App\Models\User;

use App\Models\Base;

class UserOrder extends Base
{
  protected $fillable = [
    'user_id',
    'user_orderable_type',
    'user_orderable_id',
    'amount',
    'pay_status',
    'coupon_id',
    'coupon_amount',
    'pay_type',
    'paid_at',
    'source'
  ];

  protected $casts = [
    'amount' => 'float',
    'user_orderable_id' => 'string'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
