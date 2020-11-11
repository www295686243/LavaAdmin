<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/11
 * Time: 19:29
 */

namespace App\Models\Task\Traits;

use App\Models\Api\User;
use App\Models\Task\Task;
use App\Models\Task\TaskRecord;

trait FollowWeChatTraits {
  /**
   * @param Task $taskData
   * @return TaskRecord|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
   */
  public function createFollowWeChatTask(Task $taskData) {
    $taskRecordData = TaskRecord::where('user_id', User::getUserId())
      ->where('task_id', $taskData->id)
      ->first();
    if (!$taskRecordData) {
      $taskRecordData = TaskRecord::create([
        'user_id' => User::getUserId(),
        'task_id' => $taskData->id,
        'title' => $taskData->title,
        'task_mode' => $taskData->task_mode,
        'task_type' => $taskData->task_type,
        'rewards' => $taskData->rewards
      ]);
      $this->createSubTask($taskData, $taskRecordData);
    }
    return $taskRecordData;
  }
}