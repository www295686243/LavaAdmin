<?php

namespace App\Models\Task;

use App\Models\Base\Base;

class Task extends Base
{
  protected $fillable = [
    'title',
    'desc',
    'task_type',
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
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function task_rule()
  {
    return $this->hasMany(TaskRule::class);
  }

  public static function bootHasSnowflakePrimary() {}

  /**
   * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
   */
  public function cacheGetAll()
  {
    return $this->with('task_rule')->get();
  }
}
