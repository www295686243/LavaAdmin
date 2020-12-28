<?php

namespace App\Models;

use App\Models\User\User;
use App\Models\Base\Base;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * App\Models\ApiLog
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property string|null $nickname
 * @property string|null $name
 * @property string $method
 * @property string $path
 * @property string $ip
 * @property array|null $input
 * @property array|null $extra
 * @property string $status 结果状态
 * @property int $code 状态码
 * @property string|null $desc 描述
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiLog whereUserId($value)
 * @mixin \Eloquent
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
    'extra',
    'status',
    'code',
    'desc'
  ];

  protected $casts = [
    'input' => 'array',
    'extra' => 'array',
  ];

  public static function bootHasSnowflakePrimary() {}

  public function createLog($params)
  {
    $user = User::getUserData();
    $method = request()->getMethod();
    $path = request()->getPathInfo();
    if ($path === '/api/wechat/login' || Str::contains($path, 'pay_callback')) {
      $user = User::findOrFail($params['data']['user_id']);
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
        'extra' => $params['extra'],
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
