<?php

namespace App\Http\Controllers\Admin\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Task\TaskRecordRequest;
use App\Models\Task\TaskRecord;

class TaskRecordController extends Controller
{
  /**
   * @param TaskRecordRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(TaskRecordRequest $request)
  {
    $task_id = $request->input('task_id');
    $data = TaskRecord::with(['user:id,nickname', 'task_recordable'])
      ->where('task_id', $task_id)
      ->searchQuery()
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }
}
