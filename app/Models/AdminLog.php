<?php

namespace App\Models;

use App\Models\Admin\User;

/**
 * \App\Models\AdminLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $nickname
 * @property string $method
 * @property string $path
 * @property string $ip
 * @property array|null $input
 * @property string $status 结果状态
 * @property int $code 状态码
 * @property string|null $desc 描述
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdminLog whereUserId($value)
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
    $user = User::getUserData();
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
