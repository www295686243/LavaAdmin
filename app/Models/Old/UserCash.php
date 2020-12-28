<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\UserCash
 *
 * @property int $id
 * @property int $user_id
 * @property string $amount 提现金额
 * @property int $status 0占位1申请中2已通过3已拒绝4已撤回
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash whereUserId($value)
 * @mixin \Eloquent
 */
class UserCash extends Model
{
  protected $connection = 'zhizao';
}
