<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/11
 * Time: 19:54
 */

namespace App\Models\Task\Traits;

use App\Models\Api\User;
use App\Models\Task\Task;
use App\Models\Task\TaskRecord;

trait InviteUserTraits {
  public function createInviteUserTask(Task $taskData)
  {
    $invite_user_id = request()->input('iu');
    if ($invite_user_id) {
      $userData = User::getUserData();
      /**
       * @var TaskRecord $taskRecordData
       */
      $taskRecordData = $userData->task_record()
        ->where('user_id', $invite_user_id)
        ->where('task_id', $taskData->id)
        ->first();
      if (!$taskRecordData) {
        $taskRecordData = $userData->task_record()->create([
          'user_id' => $invite_user_id,
          'task_id' => $taskData->id,
          'title' => $taskData->title,
          'task_name' => $taskData->task_name,
          'task_mode' => $taskData->task_mode,
          'task_type' => $taskData->task_type,
          'rewards' => $taskData->rewards
        ]);
        $this->createSubTask($taskData, $taskRecordData);
      }
      return $taskRecordData;
    }
    return null;
  }
}