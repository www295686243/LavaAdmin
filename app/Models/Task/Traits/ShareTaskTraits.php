<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/11
 * Time: 16:40
 */

namespace App\Models\Task\Traits;

use App\Models\Coupon\CouponTemplate;
use App\Models\Notify\NotifyTemplate;
use App\Models\Task\Task;
use App\Models\Task\TaskRule;

trait ShareTaskTraits {
  private function getShareMainTask () {
    $share_user_id = request()->input('su');
    if (!$share_user_id) return null;
    $taskRecordData = $this->task_record()
      ->where('user_id', $share_user_id)
      ->where('task_id', 1)
      ->first();
    if ($taskRecordData && $taskRecordData->is_complete) return null;
    if (!$taskRecordData) {
      $taskData = Task::findOrFail(1);
      $taskRecordData = $this->task_record()->create([
        'user_id' => $share_user_id,
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_type' => $taskData->task_type
      ]);
    }
    return $taskRecordData;
  }

  private function getShareSubTask($taskRecordData)
  {
    if (!$taskRecordData) return null;
    if ($this->getTable() === 'hr_jobs') {
      $taskRuleData = TaskRule::findOrFail(2);
    } else if ($this->getTable() === 'hr_resumes') {
      $taskRuleData = TaskRule::findOrFail(1);
    }
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

  public function checkShareFinishTask()
  {
    $taskRecordData = $this->getShareMainTask();
    $taskRuleRecordData = $this->getShareSubTask($taskRecordData);
    if ($taskRecordData && $taskRuleRecordData) {
      $count = $this->info_view()
        ->where('share_user_id', $taskRecordData->user_id)
        ->where('is_new_user', 1)
        ->count();
      $taskRuleRecordData->complete_number = $count;
      if ($taskRuleRecordData->complete_number >= $taskRuleRecordData->target_number) {
        $taskRecordData->is_complete = 1;
        $taskRecordData->task_complete_time = date('Y-m-d H:i:s');
        $taskRecordData->save();

        $taskRuleRecordData->is_complete = 1;
        $taskRuleRecordData->task_complete_time = date('Y-m-d H:i:s');

        $this->checkShareRewards($taskRecordData, $taskRuleRecordData);
      }
      $taskRuleRecordData->save();
    }
  }

  /**
   * @param $taskRecordData
   * @param $taskRuleRecordData
   * @throws \Exception
   */
  private function checkShareRewards($taskRecordData, $taskRuleRecordData)
  {
    if ($taskRuleRecordData->rewards) {
      $share_user_id = request()->input('su');
      $title = $taskRecordData->title === $taskRuleRecordData->title ? $taskRecordData->title : $taskRecordData->title.'-'.$taskRuleRecordData->title;
      $giveCouponsText = CouponTemplate::giveManyCoupons($share_user_id, $taskRuleRecordData->rewards, $title);
      // 送券通知
      if ($this->getTable() === 'hr_jobs') {
        NotifyTemplate::sendGiveCoupon(
          39,
          '职位分享任务互助券赠送成功通知',
          $share_user_id,
          [
            'title' => $this->title,
            'giveCouponsText' => $giveCouponsText
          ]
        );
      } else if ($this->getTable() === 'hr_resumes') {
        NotifyTemplate::sendGiveCoupon(
          33,
          '简历分享任务互助券赠送成功通知',
          $share_user_id,
          [
            'title' => $this->title,
            'giveCouponsText' => $giveCouponsText
          ]
        );
      }
    }
  }
}
