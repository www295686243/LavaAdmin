<?php

namespace App\Models\Task;

use App\Models\Base;

class TaskRule extends Base
{
  protected $fillable = [
    'task_id',
    'title',
    'target_number',
    'rewards'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'rewards' => 'array'
  ];

  /**
   * @param $value
   * @return array|mixed
   */
  public function getRewardsAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

  public static function bootHasSnowflakePrimary() {}
}
