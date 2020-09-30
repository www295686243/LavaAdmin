<?php

namespace App\Models\Task;

use App\Models\Base;

class TaskRule extends Base
{
  protected $fillable = [
    'task_id',
    'title',
    'get_number',
    'rules',
    'rewards'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'rules' => 'array',
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
}
