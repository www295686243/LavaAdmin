<?php
/**
 * Created by PhpStorm.
 * User: wanx
 * Date: 2020/11/11
 * Time: 19:42
 */

namespace App\Models\Task\Traits;

use App\Models\Api\User;
use App\Models\Info\InfoCheck;
use App\Models\Task\Task;
use App\Models\Task\TaskRecord;

trait PerfectPersonalInfoTraits {
  /**
   * @param Task $taskData
   * @return TaskRecord|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
   */
  public function createPerfectPersonalInfoTask(Task $taskData)
  {
    $userData = User::getUserData();
    if ($userData->is_admin) {
      $infoCheckData = InfoCheck::findOrFail(request()->input('id'));
      return TaskRecord::where('user_id', $infoCheckData->user_id)
        ->where('task_id', $taskData->id)
        ->first();
    } else {
      $taskRecordData = TaskRecord::where('user_id', $userData->id)
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
}