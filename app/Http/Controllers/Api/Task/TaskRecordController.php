<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Models\Api\User;
use App\Models\Task\Task;
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
        $query->orWhereIn('task_name', [
          Task::getOptionsValue('task_name', 2, '关注公众号'),
          Task::getOptionsValue('task_name', 3, '绑定手机号'),
          Task::getOptionsValue('task_name', 4, '完善个人资料'),
          Task::getOptionsValue('task_name', 5, '完善企业资料'),
        ])
          ->orWhere(function (Builder $query) {
            $query->whereIn('task_name', [
              Task::getOptionsValue('task_name', 6, '个人每天登录'),
              Task::getOptionsValue('task_name', 7, '企业每天登录'),
            ])
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
    $taskData = Task::where('task_name', Task::getOptionsValue('task_name', 1, '分享信息'))
      ->firstOrFail();
    $data = TaskRecord::with('task_rule_record', 'task_recordable:id,title')
      ->where('user_id', User::getUserId())
      ->where('task_id', $taskData->id)
      ->simplePagination();
    return $this->setParams($data)->success();
  }
}
