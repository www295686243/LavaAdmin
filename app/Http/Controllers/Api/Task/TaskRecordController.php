<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\TaskRecordRequest;
use App\Models\Api\User;
use App\Models\Task\TaskRecord;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TaskRecordController extends Controller
{
  public function index()
  {
    $data = TaskRecord::where('user_id', User::getUserId())
      ->where(function (Builder $query) {
        $query->orWhereIn('title', ['关注公众号', '绑定手机号', '完善个人资料', '完善企业资料'])
          ->orWhere(function (Builder $query) {
            $query->whereIn('title', ['个人每天登录', '企业每天登录'])
              ->where('task_complete_time', '>', date('Y-m-d 00:00:00'));
          });
      })
      ->get();
    return $this->setParams($data)->success();
  }
}
