<?php

namespace App\Models\Task;

use App\Models\Base;

class TaskRuleRecord extends Base
{
  protected $fillable = [
    'user_id',
    'task_record_id',
    'task_rule_recordable_type',
    'task_rule_recordable_id',
    'task_rule_name',
    'operator',
    'target_number',
    'complete_number',
    'rewards'
  ];

  protected $casts = [
    'task_rule_recordable_id' => 'string',
    'task_record_id',
    'rewards' => 'array'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function task_rule_recordable()
  {
    return $this->morphTo();
  }
}
