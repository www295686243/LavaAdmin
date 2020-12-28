<?php

namespace App\Models;

use App\Models\User\User;
use App\Models\Base\Base;

/**
 * App\Models\AdminLog
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property string $nickname
 * @property string $name
 * @property string $method
 * @property string $path
 * @property string $ip
 * @property array|null $input
 * @property string $status 结果状态
 * @property int $code 状态码
 * @property string|null $desc 描述
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog whereInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminLog whereUserId($value)
 * @mixin \Eloquent
 */
class AdminLog extends Base
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

  public static function bootHasSnowflakePrimary() {}

  public function createLog($params)
  {
    $user = User::getUserData();
    $method = request()->getMethod();
    if ($user && $method !== 'GET') {
      self::create([
        'user_id' => $user->id,
        'nickname' => optional($user)->nickname ?: optional($user)->username,
        'name' => class_basename(request()->route()->getActionName()),
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
