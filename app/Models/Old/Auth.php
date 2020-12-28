<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\Auth
 *
 * @property int $id
 * @property int $user_id 关联的用户id
 * @property string $wx_openid 微信用户唯一id
 * @property string|null $wx_unionid 微信跨平台登录id(暂未用到)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Auth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Auth query()
 * @method static \Illuminate\Database\Eloquent\Builder|Auth whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auth whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auth whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auth whereWxOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Auth whereWxUnionid($value)
 * @mixin \Eloquent
 */
class Auth extends Model
{
  protected $connection = 'zhizao';
}
