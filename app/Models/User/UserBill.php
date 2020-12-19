<?php

namespace App\Models\User;

use App\Models\Base\Base;

class UserBill extends Base
{
  protected $fillable = [
    'user_id',
    'user_billable_type',
    'user_billable_id',
    'total_amount',
    'cash_amount',
    'balance_amount',
    'coupon_amount',
    'desc'
  ];

  protected $casts = [
    'total_amount' => 'float',
    'cash_amount' => 'float',
    'balance_amount' => 'float',
    'coupon_amount' => 'float',
    'user_billable_id' => 'string'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function user_billable()
  {
    return $this->morphTo();
  }
}
