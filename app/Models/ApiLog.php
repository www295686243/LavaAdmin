<?php

namespace App\Models;

use App\Models\Api\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ApiLog whereName($value)
 */
class ApiLog extends Base
{
  protected $fillable = [
    'user_id',
    'nickname',
    'name',
    'method',
    'path',
    'ip',
    'input',
    'status',
    'code',
    'desc'
  ];

  protected $casts = [
    'input' => 'array',
  ];

  public function createLog($params)
  {
    $user = User::getUserData();
    $method = request()->getMethod();
    $path = request()->getPathInfo();
    if ($path === '/api/wechat/login') {
      $user = User::findOrFail($params['data']['user_id']);
    } else if ($path === '/api/wechat/pay_callback') {
      \Log::info($params);
    }
    if ($user && $method !== 'GET' && $path !== '/api/api_log') {
      self::create([
        'user_id' => $user->id,
        'nickname' => $user->nickname,
        'name' => class_basename(request()->route()->getActionName()),
        'method' => $method,
        'path' => $path,
        'ip' => request()->getClientIp(),
        'input' => request()->all(),
        'status' => $params['status'],
        'code' => $params['code'],
        'desc' => $params['desc']
      ]);
    }
  }

  public static function storeLog()
  {
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    $api_logs = Cache::tags('app')->get('api_logs:'.$yesterday, []);
    if (count($api_logs) > 0) {
      DB::table('api_logs')->insert($api_logs);
    }
    Cache::tags('app')->forget('api_logs:'.$yesterday);
  }
}
