<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/11
 * Time: 19:48
 */

namespace App\Models\Task\Traits;

use App\Models\Coupon\CouponTemplate;
use App\Models\Info\Hr\HrJob;
use App\Models\Notify\NotifyTemplate;
use App\Models\Task\Task;
use App\Models\Task\TaskRecord;
use App\Models\Task\TaskRule;

trait EnterpriseEveryDayLoginTaskTraits {
  private function getEnterpriseEveryDayLoginMainTask()
  {
    if (!$this->hasRole('Enterprise Member')) return null;
    $taskRecordData = TaskRecord::where('user_id', $this->id)
      ->where('task_id', 7)
      ->whereBetween('task_complete_time', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
      ->first();
    if ($taskRecordData && $taskRecordData->is_complete) return null;
    if (!$taskRecordData) {
      $taskData = Task::findOrFail(7);
      $taskRecordData = TaskRecord::create([
        'user_id' => $this->id,
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_type' => $taskData->task_type
      ]);
    }
    return $taskRecordData;
  }

  private function getEnterpriseEveryDayLoginSubTask($taskRecordData)
  {
    if (!$taskRecordData) return null;
    $taskRuleData = TaskRule::findOrFail(8);
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
  public function checkEnterpriseEveryDayLoginFinishTask()
  {
    $taskRecordData = $this->getEnterpriseEveryDayLoginMainTask();
    $taskRuleRecordData = $this->getEnterpriseEveryDayLoginSubTask($taskRecordData);
    if ($taskRecordData && $taskRuleRecordData) {
      $isExistsHrJob = HrJob::where('user_id', $this->id)->where('status', HrJob::getStatusValue(1, '已发布'))->exists();
      $isPerfectUserEnterpriseInfo = $this->checkPerfectEnterpriseInfo();
      if ($isExistsHrJob && $isPerfectUserEnterpriseInfo) {
        $taskRecordData->is_complete = 1;
        $taskRecordData->task_complete_time = date('Y-m-d H:i:s');
        $taskRecordData->save();

        $taskRuleRecordData->complete_number = 1;
        $taskRuleRecordData->is_complete = 1;
        $taskRuleRecordData->task_complete_time = date('Y-m-d H:i:s');
        $taskRuleRecordData->save();

        $this->checkEnterpriseEveryDayLoginRewards($taskRecordData, $taskRuleRecordData);
      }
    }
  }

  /**
   * @param $taskRecordData
   * @param $taskRuleRecordData
   * @throws \Exception
   */
  private function checkEnterpriseEveryDayLoginRewards($taskRecordData, $taskRuleRecordData)
  {
    if ($taskRuleRecordData->rewards) {
      $title = $taskRecordData->title === $taskRuleRecordData->title ? $taskRecordData->title : $taskRecordData->title.'-'.$taskRuleRecordData->title;
      CouponTemplate::giveManyCoupons($this->id, $taskRuleRecordData->rewards, $title);
      // 送券通知
      NotifyTemplate::sendGiveCoupon(
        34,
        '企业每天登陆互助券赠送成功通知',
        $this,
        [
          'nickname' => $this->nickname
        ]
      );
    }
  }
}
