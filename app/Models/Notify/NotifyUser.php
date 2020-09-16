<?php

namespace App\Models\Notify;

use App\Models\Base;
use App\Models\User\User;

class NotifyUser extends Base
{
  protected $fillable = [
    'notify_template_id',
    'user_id'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
