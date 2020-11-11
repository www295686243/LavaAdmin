<?php

namespace App\Models\Task;

use App\Models\Api\User;
use App\Models\Base;
use Illuminate\Support\Facades\Cache;

class TaskRule extends Base
{
  protected $fillable = [
    'task_id',
    'task_rule_name',
    'title',
    'operator',
    'target_number',
    'rewards',
    'task_interface'
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
  public function getRulesAttribute($value)
  {
    return $value ? json_decode($value) : [];
  }

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
