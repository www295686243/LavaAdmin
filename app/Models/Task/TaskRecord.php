<?php

namespace App\Models\Task;

use App\Models\Base;
use App\Models\User\User;
use Kra8\Snowflake\HasSnowflakePrimary;

class TaskRecord extends Base
{
  use HasSnowflakePrimary;

  protected $fillable = [
    'user_id',
    'task_id',
    'task_rule_id',
    'complete_number'
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
