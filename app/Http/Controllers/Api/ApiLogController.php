<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApiLogRequest;
use App\Models\Api\User;
use Illuminate\Support\Facades\DB;

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
    $stacks = collect($input)->map(function ($item) use ($userData, $request) {
      return [
        'user_id' => $userData->id,
        'nickname' => $userData->nickname,
        'method' => $item['method'],
        'path' => $item['path'],
        'ip' => $request->getClientIp(),
        'status' => 'success',
        'code' => 200,
        'desc' => $item['desc'],
        'created_at' => $item['time'],
        'updated_at' => $item['time']
      ];
    })->toArray();
    DB::table('api_logs')->insert($stacks);
    return $this->success();
  }
}
