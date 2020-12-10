<?php

namespace Database\Seeders\Data;

use App\Models\Task\Task;
use App\Models\Task\TaskRecord;
use App\Models\Task\TaskRule;
use App\Models\User\User;
use App\Models\User\UserEnterprise;
use App\Models\User\UserPersonal;
use Illuminate\Database\Seeder;

class TaskTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $users = User::get();
    $taskData = Task::findOrFail(3);
    $taskRuleData = TaskRule::findOrFail(4);
    $taskData2 = Task::findOrFail(2);
    $taskRuleData2 = TaskRule::findOrFail(3);
    foreach ($users as $user) {
      if ($user->phone) {
        $taskRecordData = TaskRecord::create([
          'user_id' => $user->id,
          'task_id' => $taskData->id,
          'title' => $taskData->title,
          'task_type' => $taskData->task_type,
          'is_complete' => 1,
          'task_complete_time' => date('Y-m-d H:i:s')
        ]);
        $taskRecordData->task_rule_record()->create([
          'user_id' => $taskRecordData->user_id,
          'title' => $taskRuleData->title,
          'target_number' => $taskRuleData->target_number,
          'rewards' => $taskRuleData->rewards,
          'complete_number' => 1,
          'is_complete' => 1,
          'task_complete_time' => date('Y-m-d H:i:s')
        ]);
      }

      if ($user->is_follow_official_account) {
        $taskRecordData2 = TaskRecord::create([
          'user_id' => $user->id,
          'task_id' => $taskData2->id,
          'title' => $taskData2->title,
          'task_type' => $taskData2->task_type,
          'is_complete' => 1,
          'task_complete_time' => date('Y-m-d H:i:s')
        ]);
        $taskRecordData2->task_rule_record()->create([
          'user_id' => $taskRecordData2->user_id,
          'title' => $taskRuleData2->title,
          'target_number' => $taskRuleData2->target_number,
          'rewards' => $taskRuleData2->rewards,
          'complete_number' => 1,
          'is_complete' => 1,
          'task_complete_time' => date('Y-m-d H:i:s')
        ]);
      }
    }

    $userPersonals = UserPersonal::get();
    $taskData = Task::findOrFail(4);
    $taskRuleData = TaskRule::findOrFail(5);
    foreach ($userPersonals as $item) {
      if ($item->isPerfectInfo()) {
        $taskRecordData = TaskRecord::create([
          'user_id' => $item->user_id,
          'task_id' => $taskData->id,
          'title' => $taskData->title,
          'task_type' => $taskData->task_type,
          'is_complete' => 1,
          'task_complete_time' => date('Y-m-d H:i:s')
        ]);
        $taskRecordData->task_rule_record()->create([
          'user_id' => $taskRecordData->user_id,
          'title' => $taskRuleData->title,
          'target_number' => $taskRuleData->target_number,
          'rewards' => $taskRuleData->rewards,
          'complete_number' => 1,
          'is_complete' => 1,
          'task_complete_time' => date('Y-m-d H:i:s')
        ]);
      }
    }

    $userEnterprises = UserEnterprise::get();
    $taskData = Task::findOrFail(5);
    $taskRuleData = TaskRule::findOrFail(6);
    foreach ($userEnterprises as $item) {
      if ($item->isPerfectInfo()) {
        $taskRecordData = TaskRecord::create([
          'user_id' => $item->user_id,
          'task_id' => $taskData->id,
          'title' => $taskData->title,
          'task_type' => $taskData->task_type,
          'is_complete' => 1,
          'task_complete_time' => date('Y-m-d H:i:s')
        ]);
        $taskRecordData->task_rule_record()->create([
          'user_id' => $taskRecordData->user_id,
          'title' => $taskRuleData->title,
          'target_number' => $taskRuleData->target_number,
          'rewards' => $taskRuleData->rewards,
          'complete_number' => 1,
          'is_complete' => 1,
          'task_complete_time' => date('Y-m-d H:i:s')
        ]);
      }
    }
  }
}
