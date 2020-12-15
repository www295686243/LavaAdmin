<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/11
 * Time: 19:54
 */

namespace App\Models\Task\Traits;

use App\Models\User\User;
use App\Models\Coupon\CouponTemplate;
use App\Models\Notify\NotifyTemplate;
use App\Models\Task\Task;
use App\Models\Task\TaskRecord;
use App\Models\Task\TaskRule;

trait InviteUserTaskTraits {
  private function getInviteUserMainTask()
  {
    if (!$this->invite_user_id) return null;
    $taskRecordData = $this->task_record()
      ->where('user_id', $this->invite_user_id)
      ->where('task_id', 8)
      ->first();
    if ($taskRecordData && $taskRecordData->is_complete) return null;
    if (!$taskRecordData) {
      $taskData = Task::findOrFail(8);
      $taskRecordData = TaskRecord::create([
        'user_id' => User::getUserId(),
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_type' => $taskData->task_type
      ]);
    }
    return $taskRecordData;
  }

  private function getInviteUserSubTask($taskRecordData)
  {
    if (!$taskRecordData) return null;
    $taskRuleData = TaskRule::findOrFail(9);
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
  public function checkInviteUserFinishTask()
  {
    $taskRecordData = $this->getInviteUserMainTask();
    $taskRuleRecordData = $this->getInviteUserSubTask($taskRecordData);
    if ($taskRecordData && $taskRuleRecordData && $this->phone) {
      $taskRecordData->is_complete = 1;
      $taskRecordData->task_complete_time = date('Y-m-d H:i:s');
      $taskRecordData->save();

      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->is_complete = 1;
      $taskRuleRecordData->task_complete_time = date('Y-m-d H:i:s');
      $taskRuleRecordData->save();

      $this->checkInviteUserRewards($taskRecordData, $taskRuleRecordData);
    }
  }

  /**
   * @param $taskRecordData
   * @param $taskRuleRecordData
   * @throws \Exception
   */
  private function checkInviteUserRewards($taskRecordData, $taskRuleRecordData)
  {
    if ($taskRuleRecordData->rewards) {
      $title = $taskRecordData->title === $taskRuleRecordData->title ? $taskRecordData->title : $taskRecordData->title.'-'.$taskRuleRecordData->title;
      $giveCouponsText = CouponTemplate::giveManyCoupons($this->invite_user_id, $taskRuleRecordData->rewards, $title);
      // 送券通知
      NotifyTemplate::sendGiveCoupon(
        31,
        '邀请好友互助券赠送成功通知',
        $this->invite_user_id,
        [
          'nickname' => $this->nickname,
          'giveCouponsText' => $giveCouponsText
        ]
      );
    }
  }
}
