<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/11
 * Time: 19:33
 */

namespace App\Models\Task\Traits;

use App\Models\Api\User;
use App\Models\Coupon\CouponTemplate;
use App\Models\Notify\NotifyTemplate;
use App\Models\Task\Task;
use App\Models\Task\TaskRecord;
use App\Models\Task\TaskRule;

trait BindPhoneTaskTraits {
  private function getBindPhoneMainTask()
  {
    $taskData = Task::findOrFail(3);
    $taskRecordData = TaskRecord::where('user_id', User::getUserId())
      ->where('task_id', $taskData->id)
      ->first();
    if ($taskRecordData && $taskRecordData->is_complete) return null;
    if (!$taskRecordData) {
      $taskRecordData = TaskRecord::create([
        'user_id' => User::getUserId(),
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_type' => $taskData->task_type
      ]);
    }
    return $taskRecordData;
  }

  private function getBindPhoneSubTask($taskRecordData)
  {
    if (!$taskRecordData) return null;
    $taskRuleData = TaskRule::findOrFail(4);
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
  public function checkBindPhoneFinishTask()
  {
    $taskRecordData = $this->getBindPhoneMainTask();
    $taskRuleRecordData = $this->getBindPhoneSubTask($taskRecordData);
    if ($taskRecordData && $taskRuleRecordData && $this->phone) {
      $taskRecordData->is_complete = 1;
      $taskRecordData->task_complete_time = date('Y-m-d H:i:s');
      $taskRecordData->save();

      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->is_complete = 1;
      $taskRuleRecordData->task_complete_time = date('Y-m-d H:i:s');
      $taskRuleRecordData->save();

      $this->checkBindPhoneRewards($taskRecordData, $taskRuleRecordData);
    }
  }

  /**
   * @param $taskRecordData
   * @param $taskRuleRecordData
   * @throws \Exception
   */
  private function checkBindPhoneRewards($taskRecordData, $taskRuleRecordData)
  {
    if ($taskRuleRecordData->rewards) {
      $title = $taskRecordData->title === $taskRuleRecordData->title ? $taskRecordData->title : $taskRecordData->title.'-'.$taskRuleRecordData->title;
      $giveCouponsText = CouponTemplate::giveManyCoupons($this->id, $taskRuleRecordData->rewards, $title);
      // 送券通知
      NotifyTemplate::sendGiveCoupon(
        40,
        '绑定手机号任务互助券赠送成功通知',
        $this,
        [
          'giveCouponsText' => $giveCouponsText
        ]
      );
    }
  }
}