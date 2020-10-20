<?php

namespace App\Http\Controllers\Admin\Task;

use App\Http\Controllers\Controller;
use App\Models\Task\TaskRecord;
use Illuminate\Http\Request;

class TaskRecordController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = TaskRecord::searchQuery()->with(['task_rule:id,title', 'user:id,nickname', 'task_recordable:id,title'])
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }
}
