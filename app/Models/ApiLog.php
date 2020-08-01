<?php

namespace App\Models;

use App\Models\Api\User;
/**
 * \App\Models\ApiLog
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog whereInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base pagination()
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
    $user = User::getUserData();
    $method = request()->getMethod();
    if ($user && $method !== 'GET') {
      self::create([
        'user_id' => $user->id,
        'nickname' => $user->nickname,
        'method' => $method,
        'path' => request()->getPathInfo(),
        'ip' => request()->getClientIp(),
        'input' => request()->all(),
        'status' => $params['status'],
        'code' => $params['code'],
        'desc' => $params['desc']
      ]);
    }
  }
}
