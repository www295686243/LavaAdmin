<?php

namespace App\Models\Info;

use App\Models\Base\Base;
use App\Models\Task\TaskRecord;
use App\Models\Task\Traits\InfoProvideTaskTraits;
use App\Models\User\User;

class InfoProvide extends Base
{
  use InfoProvideTaskTraits;
  protected $fillable = [
    'user_id',
    'description',
    'contacts',
    'phone',
    'status',
    'info_provideable_type',
    'info_provideable_id',
    'admin_user_id',
    'is_admin',
    'is_reward'
  ];

  protected $casts = [
    'info_provideable_id' => 'string',
    'admin_user_id' => 'string',
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

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function task_record()
  {
    return $this->morphMany(TaskRecord::class, 'task_recordable');
  }
}
