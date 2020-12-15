<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/15
 * Time: 13:44
 */

namespace App\Models\Task\Traits;

use App\Models\Coupon\CouponTemplate;
use App\Models\Info\InfoProvide;
use App\Models\Notify\NotifyTemplate;
use App\Models\Task\Task;
use App\Models\Task\TaskRule;
use Illuminate\Support\Str;

trait InfoProvideTaskTraits {
  public function getTask()
  {
    $taskData = Task::findOrFail(9);
    $taskRecordData = $this->task_record()->create([
      'user_id' => $this->user_id,
      'task_id' => $taskData->id,
      'title' => $taskData->title,
      'task_type' => $taskData->task_type
    ]);

    $taskRuleData = null;
    if (Str::contains($this->info_provideable_type, 'HrJob')) {
      $taskRuleData = TaskRule::findOrFail(10);
    } else if (Str::contains($this->info_provideable_type, 'HrResume')) {
      $taskRuleData = TaskRule::findOrFail(11);
    }
    if ($taskRuleData) {
      $taskRecordData->task_rule_record()->create([
        'user_id' => $taskRecordData->user_id,
        'title' => $taskRuleData->title,
        'target_number' => $taskRuleData->target_number,
        'rewards' => $taskRuleData->rewards,
      ]);
    }
  }

  public function checkFinishTask()
  {
    if ($this->status !== InfoProvide::getStatusValue(1, '待审核')) {
      $taskRecordData = $this->task_record()->first();
      $taskRecordData->is_complete = 1;
      $taskRecordData->task_complete_time = date('Y-m-d H:i:s');
      $taskRecordData->save();

      $taskRuleRecordData = $taskRecordData->task_rule_record()->first();
      $taskRuleRecordData->complete_number = 1;
      $taskRuleRecordData->is_complete = 1;
      $taskRuleRecordData->task_complete_time = date('Y-m-d H:i:s');
      $taskRuleRecordData->save();

      $this->checkRewards($taskRecordData, $taskRuleRecordData);
    }
  }

  private function checkRewards($taskRecordData, $taskRuleRecordData)
  {
    if ($taskRuleRecordData->rewards) {
      $title = $taskRecordData->title === $taskRuleRecordData->title ? $taskRecordData->title : $taskRecordData->title.'-'.$taskRuleRecordData->title;
      CouponTemplate::giveManyCoupons($this->user_id, $taskRuleRecordData->rewards, $title);
      // 送券通知
      $pushText = request()->input('push_text');
      NotifyTemplate::sendGiveCoupon(
        36,
        '信息提供互助券赠送成功通知',
        $this->user_id,
        [
          'push_text' => $pushText
        ]
      );
    }
  }
}
