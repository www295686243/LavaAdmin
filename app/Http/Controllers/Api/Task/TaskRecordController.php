<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\Task\TaskRecord;
use Illuminate\Database\Eloquent\Builder;

class TaskRecordController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $data = TaskRecord::where('user_id', User::getUserId())
      ->where(function (Builder $query) {
        $query->orWhereIn('task_id', [2, 3, 4, 5])
          ->orWhere(function (Builder $query) {
            $query->whereIn('task_id', [6, 7])
              ->where('task_complete_time', '>', date('Y-m-d 00:00:00'));
          });
      })
      ->get();
    return $this->setParams($data)->success();
  }

  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function shareIndex()
  {
    $data = TaskRecord::with('task_rule_record', 'task_recordable:id,title')
      ->where('user_id', User::getUserId())
      ->where('task_id', 1)
      ->simplePagination();
    return $this->setParams($data)->success();
  }
}
