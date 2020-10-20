<?php

namespace App\Models\Info;

use App\Models\Base;
use App\Models\User\User;

class InfoShare extends Base
{
  protected $fillable = [
    'share_user_id',
    'info_shareable_type',
    'info_shareable_id',
    'info_title',
    'info_user_id',
    'is_complete'
  ];

  protected $casts = [
    'share_user_id' => 'string',
    'info_shareable_id' => 'string',
    'info_user_id' => 'string',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function share_user()
  {
    return $this->belongsTo(User::class, 'share_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function info_shareable()
  {
    return $this->morphTo();
  }
}
