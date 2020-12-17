<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/11
 * Time: 19:29
 */

namespace App\Models\Task\Traits;

use App\Models\Coupon\CouponTemplate;
use App\Models\Notify\NotifyTemplate;
use App\Models\Task\Task;
use App\Models\Task\TaskRecord;
use App\Models\Task\TaskRule;

trait FollowWeChatTaskTraits {
  /**
   * @return TaskRecord|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
   */
  private function getFollowWeChatMainTask()
  {
    $taskData = Task::findOrFail(2);
    $taskRecordData = TaskRecord::where('user_id', $this->id)
      ->where('task_id', $taskData->id)
      ->first();
    if ($taskRecordData && $taskRecordData->is_complete) return null;
    if (!$taskRecordData) {
      $taskRecordData = TaskRecord::create([
        'user_id' => $this->id,
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_type' => $taskData->task_type
      ]);
    }
    return $taskRecordData;
  }

  /**
   * @param $taskRecordData
   * @return null
   */
  private function getFollowWeChatSubTask($taskRecordData)
  {
    if (!$taskRecordData) return null;
    $taskRuleData = TaskRule::findOrFail(3);
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
  public function checkFollowWeChatFinishTask()
  {
    $taskRecordData = $this->getFollowWeChatMainTask();
    $taskRuleRecordData = $this->getFollowWeChatSubTask($taskRecordData);
    if ($taskRecordData && $taskRuleRecordData && $this->is_follow_official_account) {
      $taskRecordData->is_complete = 1;
      $taskRecordData->task_complete_time = date('Y-m-d H:i:s');
      $taskRecordData->save();

      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->is_complete = 1;
      $taskRuleRecordData->task_complete_time = date('Y-m-d H:i:s');
      $taskRuleRecordData->save();

      $this->checkFollowWeChatRewards($taskRecordData, $taskRuleRecordData);
    }
  }

  /**
   * @param $taskRecordData
   * @param $taskRuleRecordData
   * @throws \Exception
   */
  private function checkFollowWeChatRewards($taskRecordData, $taskRuleRecordData)
  {
    if ($taskRuleRecordData->rewards) {
      $title = $taskRecordData->title === $taskRuleRecordData->title ? $taskRecordData->title : $taskRecordData->title.'-'.$taskRuleRecordData->title;
      $giveCouponsText = CouponTemplate::giveManyCoupons($this->id, $taskRuleRecordData->rewards, $title);
      // 送券通知
      NotifyTemplate::sendGiveCoupon(
        42,
        '关注公众号任务互助券赠送成功通知',
        $this,
        [
          'giveCouponsText' => $giveCouponsText
        ]
      );
    }
  }
}
