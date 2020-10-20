<?php

namespace App\Models\User;

use App\Models\Base;

class UserCash extends Base
{
  protected $fillable = [
    'user_id',
    'amount',
    'status'
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
