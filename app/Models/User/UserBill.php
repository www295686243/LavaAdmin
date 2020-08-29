<?php

namespace App\Models\User;

use App\Models\Base;
use Kra8\Snowflake\HasSnowflakePrimary;

class UserBill extends Base
{
  use HasSnowflakePrimary;
  protected $fillable = [
    'user_id',
    'user_order_id',
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
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
