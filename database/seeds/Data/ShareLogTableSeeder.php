<?php

namespace Database\Seeders\Data;

use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\Old\ShareLog;
use App\Models\Task\Task;
use App\Models\Task\TaskRule;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class ShareLogTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $userIds = User::all()->pluck('id');
    $userIds = collect($userIds)->diff([538, 5, 5117, 8627, 3, 7, 626])->all();
    $lists = ShareLog::whereIn('share_user_id', $userIds)
      ->where('created_at', '>', date('Y-m-d H:i:s',strtotime('-1 month')))
      ->where('is_complete_task', 0)
      ->get();

    $taskData = Task::findOrFail(1);
    $taskRuleData2 = TaskRule::findOrFail(2);
    $taskRuleData1 = TaskRule::findOrFail(1);

    foreach ($lists as $item) {
      if ($item->info_classify === 'job') {
        $infoData = HrJob::find($item->info_id);
        $taskRuleData = $taskRuleData2;
      } else {
        $infoData = HrResume::find($item->info_id);
        $taskRuleData = $taskRuleData1;
      }
      $taskRecordData = $infoData->task_record()->create([
        'user_id' => $item->share_user_id,
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_type' => $taskData->task_type
      ]);
      $taskRecordData->task_rule_record()->create([
        'user_id' => $taskRecordData->user_id,
        'title' => $taskRuleData->title,
        'target_number' => $taskRuleData->target_number,
        'rewards' => $taskRuleData->rewards,
      ]);
    }
  }
}
