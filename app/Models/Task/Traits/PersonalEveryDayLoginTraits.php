<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/11
 * Time: 19:48
 */

namespace App\Models\Task\Traits;

use App\Models\Api\User;
use App\Models\Task\Task;
use App\Models\Task\TaskRecord;

trait PersonalEveryDayLoginTraits {
  /**
   * @param Task $taskData
   * @return TaskRecord|\Illuminate\Database\Eloquent\Model|null
   */
  public function createPersonalEveryDayLoginTask(Task $taskData)
  {
    $userData = User::getUserData();
    if ($userData->hasRole('Personal Member')) {
      $exists = TaskRecord::where('user_id', User::getUserId())
        ->where('task_id', $taskData->id)
        ->whereBetween('task_complete_time', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
        ->exists();
      if (!$exists) {
        $taskRecordData = TaskRecord::create([
          'user_id' => User::getUserId(),
          'task_id' => $taskData->id,
          'title' => $taskData->title,
          'task_name' => $taskData->task_name,
          'task_mode' => $taskData->task_mode,
          'task_type' => $taskData->task_type,
          'rewards' => $taskData->rewards
        ]);
        $this->createSubTask($taskData, $taskRecordData);
        return $taskRecordData;
      }
    }
    return null;
  }
}