<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/15
 * Time: 13:44
 */

namespace App\Models\Task\Traits;

use App\Models\Api\User;
use App\Models\Info\InfoProvide;
use App\Models\Task\Task;
use App\Models\Task\TaskRecord;
use App\Models\Task\TaskRule;
use Illuminate\Support\Str;

trait ProvideInfoTraits {
  public function createProvideInfoTask(Task $taskData)
  {
    $userData = User::getUserData();
    if (!$userData->is_admin) {
      $infoData = InfoProvide::where('user_id', $userData->id)
        ->orderByDesc('id')
        ->first();
      if ($infoData) {
        /**
         * @var TaskRecord $taskRecordData
         */
        $taskRecordData = $infoData->task_record()
          ->where('user_id', $userData->id)
          ->where('task_id', $taskData->id)
          ->first();
        if (!$taskRecordData) {
          $taskRecordData = $infoData->task_record()->create([
            'user_id' => $userData->id,
            'task_id' => $taskData->id,
            'title' => $taskData->title,
            'task_name' => $taskData->task_name,
            'task_mode' => $taskData->task_mode,
            'task_type' => $taskData->task_type,
            'rewards' => $taskData->rewards
          ]);
          $this->createProvideInfoSubTask($taskData, $taskRecordData);
          return $taskRecordData;
        }
      }
    } else {
      $id = request()->input('id');
      $infoData = InfoProvide::findOrFail($id);
      return $infoData->task_record()
        ->where('user_id', $infoData->user_id)
        ->where('task_id', $taskData->id)
        ->first();
    }
    return null;
  }

  /**
   * @param Task $taskData
   * @param TaskRecord $taskRecordData
   */
  private function createProvideInfoSubTask (Task $taskData, TaskRecord $taskRecordData) {
    $_model = request()->input('_model');
    $taskRuleQuery = $taskData->task_rule();
    if (Str::contains($_model, 'HrJob')) {
      $taskRuleQuery->where('task_rule_name', TaskRule::getOptionsValue('task_rule_name', 12, '提供职位'));
    } else {
      $taskRuleQuery->where('task_rule_name', TaskRule::getOptionsValue('task_rule_name', 13, '提供人才'));
    }
    $taskRuleData = $taskRuleQuery->first();
    $taskRecordData->task_rule_record()->create([
      'user_id' => $taskRecordData->user_id,
      'task_rule_name' => $taskRuleData->task_rule_name,
      'operator' => $taskRuleData->operator,
      'target_number' => $taskRuleData->target_number,
      'rewards' => $taskRuleData->rewards,
    ]);
  }
}