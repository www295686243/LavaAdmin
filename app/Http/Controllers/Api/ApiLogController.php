<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiLogRequest;
use App\Jobs\ApiLogQueue;
use App\Models\Api\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
    $userData = User::getUserData();
    $ip = $request->getClientIp();
    $logs = collect($input)->map(function ($item) use ($userData, $request, $ip) {
      $input = Arr::get($item, 'input');
      return [
        'user_id' => $userData->id,
        'nickname' => $userData->nickname,
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
