<?php

namespace App\Models\Info;

use App\Models\Base;
use App\Models\User\User;

class InfoProvide extends Base
{
  protected $fillable = [
    'user_id',
    'description',
    'phone',
    'status',
    'info_provideable_type',
    'info_provideable_id',
    'admin_user_id',
    'is_admin',
    'is_reward'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function admin_user()
  {
    return $this->belongsTo(User::class, 'admin_user_id');
  }
}
