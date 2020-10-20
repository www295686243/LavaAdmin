<?php

namespace App\Models\Info;

use App\Models\Base;
use App\Models\User\User;

class InfoView extends Base
{
  protected $fillable = [
    'info_viewable_type',
    'info_viewable_id',
    'share_user_id',
    'user_id',
    'is_new_user'
  ];

  protected $casts = [
    'info_viewable_id' => 'string',
    'share_user_id' => 'string',
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
  public function info_viewable()
  {
    return $this->morphTo();
  }
}
