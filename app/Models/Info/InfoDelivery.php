<?php

namespace App\Models\Info;

use App\Models\Base;
use App\Models\User\User;

class InfoDelivery extends Base
{
  protected $fillable = [
    'send_user_id',
    'send_info_type',
    'send_info_id',
    'receive_user_id',
    'receive_info_type',
    'receive_info_id',
    'order_id'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function send_user()
  {
    return $this->belongsTo(User::class, 'send_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function receive_user()
  {
    return $this->belongsTo(User::class, 'receive_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function send_info()
  {
    return $this->morphTo('send_info', 'send_info_type', 'send_info_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function receive_info()
  {
    return $this->morphTo('receive_info', 'receive_info_type', 'receive_info_id');
  }
}
