<?php

namespace App\Models;

/**
 * \App\Models\ApiLog
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog query()
 * @mixin \Eloquent
 */
class ApiLog extends Base
{
  protected $fillable = [
    'user_id',
    'nickname',
    'method',
    'path',
    'ip',
    'input',
    'status',
    'code',
    'desc'
  ];

  protected $casts = [
    'input' => 'array'
  ];

  public function createLog($params)
  {
    $user = auth('api')->user();
    $method = \Request::getMethod();
    if ($user && $method !== 'GET') {
      self::create([
        'user_id' => $user->id,
        'nickname' => $user->nickname,
        'method' => $method,
        'path' => \Request::route()->uri(),
        'ip' => \Request::getClientIp(),
        'input' => \Request::all(),
        'status' => $params['status'],
        'code' => $params['code'],
        'desc' => $params['desc']
      ]);
    }
  }
}
