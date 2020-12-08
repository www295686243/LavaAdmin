<?php

namespace App\Models\Task;

use App\Models\Base;
use App\Models\User\User;

class TaskRecord extends Base
{
  protected $fillable = [
    'user_id',
    'task_id',
    'title',
    'task_recordable_type',
    'task_recordable_id',
    'task_type',
    'rewards',
    'is_complete',
    'task_end_time',
    'task_complete_time'
  ];

  protected $casts = [
    'rewards' => 'array',
    'task_recordable_id' => 'string'
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
  public function task_recordable()
  {
    return $this->morphTo();
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function task_rule_record()
  {
    return $this->hasMany(TaskRuleRecord::class);
  }
}
