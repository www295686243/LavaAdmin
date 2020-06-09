<?php

namespace App\Models;

/**
 * \App\Models\AdminLog
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog query()
 * @mixin \Eloquent
 */
class AdminLog extends Base
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
    $user = auth('admin')->user();
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
