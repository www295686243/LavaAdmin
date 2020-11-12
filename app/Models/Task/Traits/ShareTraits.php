<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/11
 * Time: 16:40
 */

namespace App\Models\Task\Traits;

use App\Models\Task\Task;
use Illuminate\Support\Str;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\Task\TaskRule;
use App\Models\Task\TaskRecord;

trait ShareTraits {
  /**
   * @param Task $taskData
   * @return TaskRecord|\Illuminate\Database\Eloquent\Model|null
   */
  public function createShareTask(Task $taskData) {
    $share_user_id = request()->input('su');
    if ($share_user_id) {
      $id = request()->input('id');
      $action = request()->route()->getActionName();
      if (Str::contains($action, 'HrJobController')) {
        $infoData = HrJob::findOrFail($id);
      } else {
        $infoData = HrResume::findOrFail($id);
      }
      /**
       * @var TaskRecord $taskRecordData
       */
      $taskRecordData = $infoData->task_record()
        ->where('user_id', $share_user_id)
        ->where('task_id', $taskData->id)
        ->first();
      if (!$taskRecordData) {
        $taskRecordData = $infoData->task_record()->create([
          'user_id' => $share_user_id,
          'task_id' => $taskData->id,
          'title' => $taskData->title,
          'task_name' => $taskData->task_name,
          'task_mode' => $taskData->task_mode,
          'task_type' => $taskData->task_type,
          'rewards' => $taskData->rewards
        ]);
        $this->createShareSubTask($taskData, $taskRecordData);
      }
      return $taskRecordData;
    }
    return null;
  }

  /**
   * @param Task $taskData
   * @param TaskRecord $taskRecordData
   */
  private function createShareSubTask (Task $taskData, TaskRecord $taskRecordData) {
    $action = request()->route()->getActionName();
    $taskRuleQuery = $taskData->task_rule();
    if (Str::contains($action, 'HrJobController')) {
      $taskRuleQuery->where('task_rule_name', TaskRule::getOptionsValue('task_rule_name', 2, '分享职位-新用户访问'));
    } else {
      $taskRuleQuery->where('task_rule_name', TaskRule::getOptionsValue('task_rule_name', 1, '分享简历-新用户访问'));
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