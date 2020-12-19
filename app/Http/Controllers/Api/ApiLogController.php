<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiLogRequest;
use App\Jobs\ApiLogQueue;
use App\Models\User\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ApiLogController extends Controller
{
  /**
   * @param ApiLogRequest $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(ApiLogRequest $request)
  {
    $input = $request->input('stack', []);
    $user_id = $request->input('user_id');
    $nickname = $request->input('nickname');
    $ip = $request->getClientIp();
    $logs = collect($input)->map(function ($item) use ($user_id, $nickname, $request, $ip) {
      $input = Arr::get($item, 'input');
      return [
        'user_id' => $user_id,
        'nickname' => $nickname,
        'method' => $item['method'],
        'path' => $item['path'],
        'ip' => $ip,
        'input' => $input ? json_encode($input) : null,
        'status' => 'success',
        'code' => 200,
        'desc' => $item['desc'],
        'created_at' => Str::of($item['time'])->contains('NaN') ? '' : $item['time'],
        'updated_at' => Str::of($item['time'])->contains('NaN') ? '' : $item['time']
      ];
    })->toArray();
    ApiLogQueue::dispatch($logs);
    return $this->success();
  }
}
