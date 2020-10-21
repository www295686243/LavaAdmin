<?php

namespace App\Models\Task;

use App\Models\Api\User;
use App\Models\Base;
use App\Models\CouponTemplate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Task extends Base
{
  protected $fillable = [
    'title',
    'desc',
    'task_name',
    'task_type',
    'task_interface',
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
      return $this->checkInterface($task->task_interface, $interface);
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
   * @param $user_id
   * @param $title
   * @param $rewards
   */
  public function taskRewards($user_id, $title, $rewards)
  {
    collect($rewards)->each(function ($reward) use ($user_id, $title) {
      if ($reward['reward_name'] === 'coupon') {
        $couponTemplateData = CouponTemplate::getCouponTemplateData($reward['coupon_template_id']);
        $couponTemplateData->giveCoupons($user_id, $reward['give_number'], $reward['amount'], $reward['expiry_day'], $title);
      }
    });
  }

  /**
   * @param $interface
   */
  public function checkFinishTask($interface)
  {
    $taskList = $this->getInterfaceTaskList($interface);
    $taskList->each(function ($task) {
      $taskOption = Task::getOptionsItem('task_name', $task->task_name);
      // 接主任务
      $taskMethod = 'create'.Str::studly($taskOption->name).'Task';
      $taskRecordData = $this->$taskMethod($task);
      // 接子任务
      $task->task_rule->each(function ($taskRule) use ($taskRecordData) {
        $taskRuleOption = TaskRule::getOptionsItem('task_name', $taskRule->task_rule_name);
        $taskRuleMethod = 'create'.Str::studly($taskRuleOption->name).'TaskRule';
        $this->$taskRuleMethod($taskRecordData, $taskRule);
      });
    });

    $taskRuleList->each(function ($taskRule) {
      $optionItem = TaskRule::getOptionsItem('task_rule_name', $taskRule->task_rule_name);
      // 接任务
      $getTaskMethod = Str::camel($optionItem->name).'GetTask';
      $taskRecordSubData = $this->$getTaskMethod($taskRule);

    });
    $taskList->each(function ($task) use ($interface) {
      /**
       * @var self $task
       */
      $task->task_rule->each(function ($taskRule) use ($task, $interface) {
        $optionItem = TaskRule::getOptionsItem('task_rule_name', $taskRule->task_rule_name);
        // 接任务
        $getTaskMethod = Str::studly($optionItem->name).'GetTask';
        $taskRecordSubData = $this->$getTaskMethod($taskRule);
        // 统计任务
        if ($taskRecordSubData) {
          $statTaskMethod = Str::camel($optionItem->name).'StatTask';
          $this->$statTaskMethod($taskRecordSubData);
        }
      });
      $task->checkRewards();
    });
  }

  /**
   * @param $taskData
   * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\MorphMany|null|object
   */
  public function createShareTask($taskData)
  {
    $infoData = $this->getModelData();
    $share_user_id = request()->input('su');
    if ($share_user_id) {
      $recordData = $infoData->task_record()->where('user_id', $share_user_id)
        ->where('task_id', $taskData->id)
        ->first();
      if (!$recordData) {
        $recordData = $infoData->task_record()->create([
          'user_id' => $share_user_id,
          'task_id' => $taskData->id,
          'rewards' => $taskData->rewards
        ]);
      }
      return $recordData;
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
    $taskRuleRecordData = $taskRecordData->task_rule_record()
      ->where('task_rule_name', $taskRule->task_rule_name)
      ->first();
    if (!$taskRuleRecordData) {
      $taskRuleRecordData = $taskRecordData->task_rule_record()->create([
        'user_id' => $taskRecordData->user_id,
        'task_rule_name' => $taskRule->task_rule_name,
        'operator' => $taskRule->operator,
        'target_number' => $taskRule->target_number,
        'rewards' => $taskRule->rewards,
      ]);
    }
    return $taskRuleRecordData;
  }

  public function registerViewStatTask($taskRecordSubData)
  {
    $infoData = $this->getModelData();
    $share_user_id = request()->input('su');
    $count = $infoData->info_view()
      ->where('share_user_id', $share_user_id)
      ->where('is_new_user', 1)
      ->count();
    $taskRecordSubData->complete_number = $count;
    $taskRecordSubData->save();
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
}
