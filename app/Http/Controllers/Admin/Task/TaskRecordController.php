<?php

namespace App\Http\Controllers\Admin\Task;

use App\Http\Controllers\Controller;
use App\Models\Task\TaskRecord;

class TaskRecordController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = TaskRecord::searchQuery()
      ->with(['user:id,nickname', 'task_recordable' => function ($query) {
        $query->select(['id', 'title']);
      }])
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }
}
