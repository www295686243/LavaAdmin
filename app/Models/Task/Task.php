<?php

namespace App\Models\Task;

use App\Models\Api\User;
use App\Models\Base;
use App\Models\Info\InfoCheck;
use App\Models\User\UserPersonal;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
    });
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
        $taskRecordObj = $this->getMainTask($taskData);
        if ($taskRecordObj) {
          /**
           * @var TaskRecord $taskRecordData
           */
          $isCreate = $taskRecordObj['isCreate'];
          $taskRecordData = $taskRecordObj['taskRecordData'];
          if ($isCreate) {
            $this->getSubTask($taskData, $taskRecordData);
          }
          $this->statTask($taskData, $taskRecordData, $interface);
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
    $taskRecordObj = $this->$taskMethod($taskData);
    return $taskRecordObj;
  }

  /**
   * @param Task $taskData
   * @param TaskRecord $taskRecordData
   */
  private function getSubTask(Task $taskData, TaskRecord $taskRecordData)
  {
    // 接子任务
    $taskData->task_rule->each(function ($taskRule) use ($taskRecordData) {
      $this->createTaskRuleRecord($taskRecordData, $taskRule);
    });
  }

  /**
   * @param Task $taskData
   * @param TaskRecord $taskRecordData
   * @param string $interface
   */
  private function statTask(Task $taskData, TaskRecord $taskRecordData, $interface = '')
  {
    if (!$taskRecordData->is_complete) {
      // 统计任务
      $taskData->task_rule
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
      $taskRecordObj = $this->getMainTask($taskData);
      if ($taskRecordObj) {
        /**
         * @var TaskRecord $taskRecordData
         */
        $isCreate = $taskRecordObj['isCreate'];
        $taskRecordData = $taskRecordObj['taskRecordData'];
        if ($isCreate) {
          $this->getSubTask($taskData, $taskRecordData);
        }
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
   * 分享任务
   * @param $taskData
   * @return array|null
   */
  public function createShareTask($taskData)
  {
    $share_user_id = request()->input('su');
    $isCreate = false;
    if ($share_user_id) {
      $infoData = $this->getModelData();
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
          'task_type' => $taskData->task_type,
          'rewards' => $taskData->rewards
        ]);
      }
      return ['isCreate' => $isCreate, 'taskRecordData' => $recordData];
    }
    return null;
  }

  /**
   * 关注公众号
   * @param $taskData
   * @return array
   */
  public function createFollowWeChatTask($taskData)
  {
    $recordData = TaskRecord::where('user_id', User::getUserId())
      ->where('task_id', $taskData->id)
      ->first();
    $isCreate = false;
    if (!$recordData) {
      $isCreate = true;
      $recordData = TaskRecord::create([
        'user_id' => User::getUserId(),
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_type' => $taskData->task_type,
        'rewards' => $taskData->rewards
      ]);
    }
    return ['isCreate' => $isCreate, 'taskRecordData' => $recordData];
  }

  /**
   * 绑定手机号
   * @param $taskData
   * @return array
   */
  public function createBindPhoneTask($taskData)
  {
    $recordData = TaskRecord::where('user_id', User::getUserId())
      ->where('task_id', $taskData->id)
      ->first();
    $isCreate = false;
    if (!$recordData) {
      $isCreate = true;
      $recordData = TaskRecord::create([
        'user_id' => User::getUserId(),
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_type' => $taskData->task_type,
        'rewards' => $taskData->rewards
      ]);
    }
    return ['isCreate' => $isCreate, 'taskRecordData' => $recordData];
  }

  /**
   * 完善个人简历信息
   * @param $taskData
   * @return array
   */
  public function createPerfectUserInfoTask($taskData)
  {
    $userData = User::getUserData();
    if ($userData->is_admin) {
      $info_check_id = request()->input('id');
      $infoCheckData = InfoCheck::findOrFail($info_check_id);
      $user_id = $infoCheckData->user_id;
    } else {
      $user_id = User::getUserId();
    }
    $recordData = TaskRecord::where('user_id', $user_id)
      ->where('task_id', $taskData->id)
      ->first();
    $isCreate = false;
    if (!$recordData) {
      $isCreate = true;
      $recordData = TaskRecord::create([
        'user_id' => $user_id,
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_type' => $taskData->task_type,
        'rewards' => $taskData->rewards
      ]);
    }
    return ['isCreate' => $isCreate, 'taskRecordData' => $recordData];
  }

  /**
   * 企业每天登录
   * @param $taskData
   * @return array
   */
  public function createEnterpriseEveryDayLoginTask($taskData)
  {
    $userData = User::getUserData();
    if ($userData->hasRole('Enterprise Member')) {
      $recordData = TaskRecord::create([
        'user_id' => $userData->id,
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_type' => $taskData->task_type,
        'rewards' => $taskData->rewards
      ]);
      return ['isCreate' => true, 'taskRecordData' => $recordData];
    }
    return null;
  }

  /**
   * 个人每天登录
   * @param $taskData
   * @return array
   */
  public function createPersonalEveryDayLoginTask($taskData)
  {
    $userData = User::getUserData();
    if ($userData->hasRole('Personal Member')) {
      $recordData = TaskRecord::create([
        'user_id' => $userData->id,
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_type' => $taskData->task_type,
        'rewards' => $taskData->rewards
      ]);
      return ['isCreate' => true, 'taskRecordData' => $recordData];
    }
    return null;
  }

  /**
   * @param $taskData
   * @return array|null
   */
  public function createInviteUserTask($taskData)
  {
    $invite_user_id = request()->input('iu');
    $isCreate = false;
    if ($invite_user_id) {
      $userData = User::getUserData();
      $recordData = $userData->task_record()
        ->where('user_id', $invite_user_id)
        ->where('task_id', $taskData->id)
        ->first();
      if (!$recordData) {
        $isCreate = true;
        $recordData = $userData->task_record()->create([
          'user_id' => $invite_user_id,
          'task_id' => $taskData->id,
          'title' => $taskData->title,
          'task_type' => $taskData->task_type,
          'rewards' => $taskData->rewards
        ]);
      }
      return ['isCreate' => $isCreate, 'taskRecordData' => $recordData];
    }
    return null;
  }

  /**
   * @param TaskRecord $taskRecordData
   * @param TaskRule $taskRuleData
   * @return mixed
   */
  public function createTaskRuleRecord($taskRecordData, $taskRuleData)
  {
    $taskRuleRecordData = $taskRecordData->task_rule_record()->create([
      'user_id' => $taskRecordData->user_id,
      'task_rule_name' => $taskRuleData->task_rule_name,
      'operator' => $taskRuleData->operator,
      'target_number' => $taskRuleData->target_number,
      'rewards' => $taskRuleData->rewards,
    ]);
    return $taskRuleRecordData;
  }

  public function statRegisterViewTaskRule($taskRuleRecordData)
  {
    $infoData = $this->getModelData();
    $count = $infoData->info_view()
      ->where('share_user_id', $taskRuleRecordData->user_id)
      ->where('is_new_user', 1)
      ->count();
    $taskRuleRecordData->complete_number = $count;
    $taskRuleRecordData->save();
  }

  public function statViewTaskRule($taskRuleRecordData)
  {
    $infoData = $this->getModelData();
    $share_user_id = request()->input('su');
    $count = $infoData->info_view()
      ->where('share_user_id', $share_user_id)
      ->count();
    $taskRuleRecordData->complete_number = $count;
    $taskRuleRecordData->save();
  }

  public function statFollowWeChatTaskRule($taskRuleRecordData)
  {
    $userData = User::getUserData($taskRuleRecordData->user_id);
    if ($userData->is_follow_official_account) {
      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->save();
    }
  }

  public function statBindPhoneTaskRule($taskRuleRecordData)
  {
    $userData = User::getUserData($taskRuleRecordData->user_id);
    if ($userData->phone) {
      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->save();
    }
  }

  public function statPerfectUserInfoTaskRule($taskRuleRecordData)
  {
    $userPersonalData = UserPersonal::where('user_id', $taskRuleRecordData->user_id)->firstOrFail();
    if (
      $userPersonalData->tags &&
      ($userPersonalData->education_experience && count($userPersonalData->education_experience)) &&
      ($userPersonalData->work_experience && count($userPersonalData->work_experience))
    ) {
      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->save();
    }
  }

  public function statEnterpriseEveryDayLoginTaskRule($taskRuleRecordData)
  {
    $taskRuleRecordData->complete_number = 1;
    $taskRuleRecordData->save();
  }

  public function statPersonalEveryDayLoginTaskRule($taskRuleRecordData)
  {
    $taskRuleRecordData->complete_number = 1;
    $taskRuleRecordData->save();
  }

  public function statInviteUserTaskRule($taskRuleRecordData)
  {
    $userData = User::getUserData();
    if ($userData->phone && $userData->invite_user_id === $taskRuleRecordData->user_id) {
      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->save();
    }
    \Log::info($taskRuleRecordData);
    \Log::info($userData);
  }
}
