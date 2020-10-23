<?php

namespace App\Http\Controllers\Admin\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Task\TaskRuleRecordRequest;
use App\Models\Task\TaskRuleRecord;
use Illuminate\Http\Request;

class TaskRuleRecordController extends Controller
{
  /**
   * @param TaskRuleRecordRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(TaskRuleRecordRequest $request)
  {
    $task_record_id = $request->input('task_record_id');
    $data = TaskRuleRecord::where('task_record_id', $task_record_id)
      ->orderByDesc('id')
      ->pagination();
    return $this->setParams($data)->success();
  }
}
