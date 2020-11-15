<?php

namespace App\Models\Task;

use App\Models\Api\User;
use App\Models\Base;
use App\Models\Info\InfoCheck;
use App\Models\Task\Traits\BindPhoneTraits;
use App\Models\Task\Traits\EnterpriseEveryDayLoginTraits;
use App\Models\Task\Traits\FollowWeChatTraits;
use App\Models\Task\Traits\InviteUserTraits;
use App\Models\Task\Traits\PerfectEnterpriseInfoTraits;
use App\Models\Task\Traits\PerfectPersonalInfoTraits;
use App\Models\Task\Traits\PersonalEveryDayLoginTraits;
use App\Models\Task\Traits\ProvideInfoTraits;
use App\Models\Task\Traits\ShareTraits;
use App\Models\Task\Traits\StatTraits;
use App\Models\User\UserPersonal;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Task extends Base
{
  use
    ShareTraits,
    FollowWeChatTraits,
    BindPhoneTraits,
    PerfectEnterpriseInfoTraits,
    PerfectPersonalInfoTraits,
    EnterpriseEveryDayLoginTraits,
    PersonalEveryDayLoginTraits,
    InviteUserTraits,
    ProvideInfoTraits,
    StatTraits;

  protected $fillable = [
    'title',
    'desc',
    'task_name',
    'task_mode',
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
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function cacheGetAll()
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
    return $this->cacheGetAll()->filter(function ($task) use ($interface) {
      $task_interface = $task->task_rule()->get()->implode('task_interface', ',');
      return $this->checkInterface($task_interface, $interface);
    })->values();
  }

  /**
   * @param $task_interface
   * @param string $interface
   * @return bool
   */
  private function checkInterface($task_interface, $interface = '')
  {
    if (!$interface) return true;
    $arr = explode(',', $task_interface);
    $arr = collect($arr)->map(function ($item) {
      $item = str_replace('/', '\\', $item);
      return $item;
    })->toArray();
    return in_array($interface, $arr);
  }

  /**
   * @param $interface
   * @throws \Throwable
   */
  public function checkFinishTask($interface)
  {
    $taskList = $this->getInterfaceTaskList($interface);
    DB::beginTransaction();
    try {
      $taskList->each(function ($taskData) use ($interface) {
        $taskRecordData = $this->getMainTask($taskData);
        if ($taskRecordData) {
          $this->statTask($taskRecordData);
          $this->rewardTask($taskRecordData);
        }
      });
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().'。'.$e->getFile().'：'.$e->getLine());
    }
  }

  /**
   * @param Task $taskData
   * @return mixed
   */
  private function getMainTask(Task $taskData)
  {
    $taskOption = Task::getOptionsItem('task_name', $taskData->task_name);
    $taskMethod = 'create'.Str::studly($taskOption->name).'Task';
    return $this->$taskMethod($taskData);
  }

  /**
   * @param TaskRecord $taskRecordData
   */
  private function statTask(TaskRecord $taskRecordData)
  {
    if (!$taskRecordData->is_complete) {
      $taskRecordData->task_rule_record->each(function ($taskRuleRecordData) {
        $taskRuleOption = TaskRule::getOptionsItem('task_rule_name', $taskRuleRecordData->task_rule_name);
        $taskRuleMethod = 'stat'.Str::studly($taskRuleOption->name).'TaskRule';
        $this->$taskRuleMethod($taskRuleRecordData);
      });
    }
  }

  /**
   * @param TaskRecord $taskRecordData
   * @throws \Exception
   */
  private function rewardTask(TaskRecord $taskRecordData) {
    // 奖励任务
    if (!$taskRecordData->is_complete) {
      $taskRecordData->checkRewards();
    }
  }

  /**
   * @param $id
   * @param $_title
   * @throws \Throwable
   */
  public function getTaskCheckFinish($id, $_title)
  {
    $taskData = Task::findOrFail($id);
    DB::beginTransaction();
    try {
      $taskRecordData = $this->getMainTask($taskData);
      if ($taskRecordData) {
        $this->statTask($taskData, $taskRecordData);
        $this->rewardTask($taskRecordData);
      }
      DB::commit();
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::error($e->getMessage().'。'.$e->getFile().'：'.$e->getLine());
    }
  }

  /**
   * @param Task $taskData
   * @param TaskRecord $taskRecordData
   */
  private function createSubTask (Task $taskData, TaskRecord $taskRecordData) {
    $taskData->task_rule->each(function (TaskRule $taskRuleData) use ($taskRecordData) {
      $taskRecordData->task_rule_record()->create([
        'user_id' => $taskRecordData->user_id,
        'task_rule_name' => $taskRuleData->task_rule_name,
        'operator' => $taskRuleData->operator,
        'target_number' => $taskRuleData->target_number,
        'rewards' => $taskRuleData->rewards,
      ]);
    });
  }
}
