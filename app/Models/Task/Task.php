<?php

namespace App\Models\Task;

use App\Models\Base;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Task extends Base
{
  protected $fillable = [
    'title',
    'desc',
    'task_interface'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function task_rule()
  {
    return $this->hasMany(TaskRule::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Collection
   */
  private function getCacheAllList()
  {
    return Cache::tags(self::class)->rememberForever($this->getTable(), function () {
      return self::all();
    });
  }

  /**
   * @param $interface
   * @return \Illuminate\Database\Eloquent\Collection
   */
  private function getMatchedTaskList($interface)
  {
    $list = $this->getCacheAllList();
    return $list->filter(function ($item) use ($interface) {
      return Str::contains($item->task_interface, $interface);
    });
  }

  public function checkFinishTask($interface)
  {
    $taskList = $this->getMatchedTaskList($interface);
    $taskList->each(function ($task) {
      $taskRuleList = $task->task_rule()->get();
      $taskRuleList->each(function ($taskRule) {
        $taskRecord = $taskRule->getRecordData();
        if ($taskRecord->complete_number < $taskRule->get_number) {
          $result = collect($taskRule->rules)->every(function ($rules) {
            return collect($rules)->some(function ($rule) {
              $method = Str::camel($rule->rule_name).'Rule';
              return $this->$method($rule);
            });
          });
          if ($result) {
            $taskRecord->complete_number += 1;
            $taskRecord->save();
          }
        }
      });
    });
  }

  public function loginRule()
  {
    return false;
  }

  public function personalUpdateRule()
  {
    return true;
  }
}
