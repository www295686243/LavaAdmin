<?php

namespace App\Models\Task;

use App\Models\Base;

class TaskRuleRecord extends Base
{
  protected $fillable = [
    'user_id',
    'task_record_id',
    'title',
    'target_number',
    'complete_number',
    'rewards',
    'is_complete',
    'task_complete_time'
  ];

  protected $casts = [
    'task_record_id' => 'string',
    'rewards' => 'array'
  ];
}
