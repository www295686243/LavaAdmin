<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/11
 * Time: 19:42
 */

namespace App\Models\Task\Traits;

use App\Models\Coupon\CouponTemplate;
use App\Models\Notify\NotifyTemplate;
use App\Models\Task\Task;
use App\Models\Task\TaskRecord;
use App\Models\Task\TaskRule;

trait PerfectPersonalInfoTaskTraits {
  private function getPerfectPersonalInfoMainTask()
  {
    $taskRecordData = TaskRecord::where('user_id', $this->user_id)
      ->where('task_id', 4)
      ->first();
    if ($taskRecordData && $taskRecordData->is_complete) return null;
    if (!$taskRecordData) {
      $taskData = Task::findOrFail(4);
      $taskRecordData = TaskRecord::create([
        'user_id' => $this->user_id,
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_type' => $taskData->task_type
      ]);
    }
    return $taskRecordData;
  }

  private function getPerfectPersonalInfoSubTask($taskRecordData)
  {
    if (!$taskRecordData) return null;
    $taskRuleData = TaskRule::findOrFail(5);
    $taskRuleRecordData = $taskRecordData->task_rule_record()->first();
    if (!$taskRuleRecordData) {
      $taskRuleRecordData = $taskRecordData->task_rule_record()->create([
        'user_id' => $taskRecordData->user_id,
        'title' => $taskRuleData->title,
        'target_number' => $taskRuleData->target_number,
        'rewards' => $taskRuleData->rewards,
      ]);
    }
    return $taskRuleRecordData;
  }

  /**
   * @throws \Exception
   */
  public function checkPerfectPersonalInfoFinishTask()
  {
    $taskRecordData = $this->getPerfectPersonalInfoMainTask();
    $taskRuleRecordData = $this->getPerfectPersonalInfoSubTask($taskRecordData);
    if ($taskRecordData && $taskRuleRecordData && $this->isPerfectInfo()) {
      $taskRecordData->is_complete = 1;
      $taskRecordData->task_complete_time = date('Y-m-d H:i:s');
      $taskRecordData->save();

      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->is_complete = 1;
      $taskRuleRecordData->task_complete_time = date('Y-m-d H:i:s');
      $taskRuleRecordData->save();

      $this->checkPerfectPersonalInfoRewards($taskRecordData, $taskRuleRecordData);
    }
  }

  /**
   * @param $taskRecordData
   * @param $taskRuleRecordData
   * @throws \Exception
   */
  private function checkPerfectPersonalInfoRewards($taskRecordData, $taskRuleRecordData)
  {
    if ($taskRuleRecordData->rewards) {
      $title = $taskRecordData->title === $taskRuleRecordData->title ? $taskRecordData->title : $taskRecordData->title.'-'.$taskRuleRecordData->title;
      $giveCouponsText = CouponTemplate::giveManyCoupons($this->user_id, $taskRuleRecordData->rewards, $title);
      // 送券通知
      NotifyTemplate::sendGiveCoupon(
        41,
        '完善个人资料任务互助券赠送成功通知',
        $this->user_id,
        [
          'giveCouponsText' => $giveCouponsText
        ]
      );
    }
  }
}