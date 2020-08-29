<?php

namespace App\Models\User;

use App\Models\Base;
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
}