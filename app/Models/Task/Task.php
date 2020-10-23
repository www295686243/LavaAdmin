<?php

namespace App\Models\Task;

use App\Models\Base;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Task extends Base
{
  protected $fillable = [
    'title',
    'desc',
    'task_name',
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

  /**
   * @return \Illuminate\Database\Eloquent\Collection
   */
  private function getCacheAllList()
  {
    return Cache::tags(self::class)->rememberForever($this->getTable(), function () {
      return self::with('task_rule')->get();
    });
  }

  /**
   * @param $interface
   * @return \Illuminate\Database\Eloquent\Collection
   */
  private function getInterfaceTaskList ($interface) {
    return $this->getCacheAllList()->filter(function ($task) use ($interface) {
      $task_interface = $task->task_rule()->implode('task_interface', ',');
      return $this->checkInterface($task_interface, $interface);
    });
  }

  private function checkInterface($task_interface, $interface)
  {
    $arr = explode(',', $task_interface);
    $arr = collect($arr)->map(function ($item) {
      $item = str_replace('/', '\\', $item);
      return $item;
    })->toArray();
    return in_array($interface, $arr);
  }

  /**
   * @param $interface
   */
  public function checkFinishTask($interface)
  {
    $taskList = $this->getInterfaceTaskList($interface);
    $taskList->each(function ($task) use ($interface) {
      $taskOption = Task::getOptionsItem('task_name', $task->task_name);
      // 接主任务
      $taskMethod = 'create'.Str::studly($taskOption->name).'Task';
      $taskRecordObj = $this->$taskMethod($task);
      if ($taskRecordObj) {
        /**
         * @var TaskRecord $taskRecordData
         */
        list($isCreate, $taskRecordData) = $taskRecordObj;
        if ($isCreate) {
          // 接子任务
          $task->task_rule->each(function ($taskRule) use ($taskRecordData, $interface) {
            $taskRuleOption = TaskRule::getOptionsItem('task_rule_name', $taskRule->task_rule_name);
            $taskRuleMethod = 'create'.Str::studly($taskRuleOption->name).'TaskRule';
            $this->$taskRuleMethod($taskRecordData, $taskRule);
          });
        }
        if (!$taskRecordData->is_complete) {
          // 统计任务
          $task->task_rule
            ->filter(function ($taskRule) use ($interface) {
              return $this->checkInterface($taskRule->task_interface, $interface);
            })
            ->each(function ($taskRule) use ($taskRecordData) {
              $taskRuleOption = TaskRule::getOptionsItem('task_rule_name', $taskRule->task_rule_name);
              $taskRuleRecordData = $taskRecordData->task_rule_record()
                ->where('task_rule_name', $taskRule->task_rule_name)
                ->first();
              $taskRuleMethod = 'stat'.Str::studly($taskRuleOption->name).'TaskRule';
              $this->$taskRuleMethod($taskRuleRecordData);
            });
        }
        // 奖励任务
        if (!$taskRecordData->is_complete) {
          $taskRecordData->checkRewards();
        }
      }
    });
  }


  /**
   * @param $taskData
   * @return array|null
   */
  public function createShareTask($taskData)
  {
    $infoData = $this->getModelData();
    $share_user_id = request()->input('su');
    $isCreate = false;
    if ($share_user_id) {
      $recordData = $infoData->task_record()
        ->where('user_id', $share_user_id)
        ->where('task_id', $taskData->id)
        ->first();
      if (!$recordData) {
        $isCreate = true;
        $recordData = $infoData->task_record()->create([
          'user_id' => $share_user_id,
          'task_id' => $taskData->id,
          'title' => $taskData->title,
          'rewards' => $taskData->rewards
        ]);
      }
      return ['isCreate' => $isCreate, 'data' => $recordData];
    }
    return null;
  }

  /**
   * @param TaskRecord $taskRecordData
   * @param TaskRule $taskRule
   * @return mixed
   */
  public function createRegisterViewTaskRule($taskRecordData, $taskRule)
  {
    $taskRuleRecordData = $taskRecordData->task_rule_record()->create([
      'user_id' => $taskRecordData->user_id,
      'task_rule_name' => $taskRule->task_rule_name,
      'operator' => $taskRule->operator,
      'target_number' => $taskRule->target_number,
      'rewards' => $taskRule->rewards,
    ]);
    return $taskRuleRecordData;
  }

  public function statRegisterViewTaskRule($taskRuleRecordData)
  {
    $infoData = $this->getModelData();
    $share_user_id = request()->input('su');
    $count = $infoData->info_view()
      ->where('share_user_id', $share_user_id)
      ->where('is_new_user', 1)
      ->count();
    $taskRuleRecordData->complete_number = $count;
    $taskRuleRecordData->save();
  }
}
