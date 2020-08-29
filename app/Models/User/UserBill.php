<?php

namespace App\Models\User;

use App\Models\Base;
use Kra8\Snowflake\HasSnowflakePrimary;

class UserBill extends Base
{
  use HasSnowflakePrimary;
  protected $fillable = [
    'user_id',
    'amount',
    'amount_type',
    'desc'
  ];

  protected $casts = [
    'amount' => 'float',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
