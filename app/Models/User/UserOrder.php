<?php

namespace App\Models\User;

use App\Models\Base;
use Kra8\Snowflake\HasSnowflakePrimary;

class UserOrder extends Base
{
  use HasSnowflakePrimary;
  protected $fillable = [
    'user_id',
    'user_orderable_type',
    'user_orderable_id',
    'total_amount',
    'cash_amount',
    'balance_amount',
    'coupon_amount',
    'coupon_id',
    'pay_status',
    'paid_at',
    'source'
  ];

  protected $casts = [
    'total_amount' => 'float',
    'cash_amount' => 'float',
    'balance_amount' => 'float',
    'coupon_amount' => 'float',
    'user_orderable_id' => 'string'
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
  public function user_orderable()
  {
    return $this->morphTo();
  }

  /**
   * @param $desc
   * @return UserBill|\Illuminate\Database\Eloquent\Model
   */
  public function createUserBill($desc)
  {
    return UserBill::create([
      'user_id' => $this->user_id,
      'user_order_id' => $this->id,
      'total_amount' => $this->total_amount,
      'cash_amount' => $this->cash_amount,
      'balance_amount' => $this->balance_amount,
      'coupon_amount' => $this->coupon_amount,
      'desc' => $desc
    ]);
  }
}
