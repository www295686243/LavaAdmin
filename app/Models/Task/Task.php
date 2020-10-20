<?php

namespace App\Models\Task;

use App\Models\Api\User;
use App\Models\Base;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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

  /**
   * @param $interface
   */
  public function checkFinishTask($interface)
  {
    $taskList = $this->getMatchedTaskList($interface);
    $taskList->each(function ($task) {
      $taskRuleList = $task->task_rule()->get();
      $taskRuleList->each(function ($taskRule) use ($task) {
        $taskRecordData = $this->getRecordData($task->task_interface, $taskRule);
        if ($taskRecordData && !$taskRecordData->is_complete) {
          $result = collect($taskRule->rules)->every(function ($rules) {
            return collect($rules)->some(function ($rule) {
              $method = Str::camel($rule->rule_name).'Rule';
              return $this->$method($rule);
            });
          });
          if ($result) {
            DB::beginTransaction();
            try {
              $taskRecordData->taskRewards();
              $taskRecordData->is_complete = 1;
              $taskRecordData->save();
              DB::commit();
            } catch (\Exception $e) {
              DB::rollBack();
              \Log::error($e->getMessage());
            }
          }
        }
      });
    });
  }

  /**
   * @param $interface
   * @param $taskRule
   * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\MorphMany|\Illuminate\Http\JsonResponse|null|object
   */
  public function getRecordData($interface, $taskRule)
  {
    $user_id = User::getUserId();
    if ($interface === 'InfoViewController@store') {
      $infoData = $this->getModelData();
      $share_user_id = request()->input('su');
      $recordData = $infoData->task_record()->where('user_id', $share_user_id)
        ->where('task_rule_id', $taskRule->id)
        ->first();
      if (!$recordData && $share_user_id) {
        $recordData = $infoData->task_record()->create([
          'user_id' => $share_user_id,
          'task_id' => $taskRule->task_id,
          'task_rule_id' => $taskRule->id,
          'rules' => $taskRule->rules,
          'rewards' => $taskRule->rewards
        ]);
      }
      return $recordData;
    }
    return $this->error('接口不存在');
  }

  public function registerViewRule($rule)
  {
    $infoData = $this->getModelData();
    $share_user_id = request()->input('su');
    $count = $infoData->info_view()
      ->where('share_user_id', $share_user_id)
      ->where('is_new_user', 1)
      ->count();
    return $this->_calc($count, $rule->target_number, $rule->operator);
  }

  /**
   * @param $arg1
   * @param $arg2
   * @param $operator
   * @return bool
   */
  private function _calc($arg1, $arg2, $operator) {
    switch ($operator) {
      case '>':
        return $arg1 > $arg2;
      case '>=':
        return $arg1 >= $arg2;
      case '=':
        return $arg1 === $arg2;
      case '<':
        return $arg1 < $arg2;
      case '<=':
        return $arg1 <= $arg2;
      default:
        return false;
    }
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
