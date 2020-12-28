<?php

namespace App\Models\User;

use App\Models\Base\Base;

/**
 * App\Models\User\UserCash
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property float $amount 提现金额
 * @property int $status 0占位1申请中2已通过3已拒绝4已撤回5已转款
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \App\Models\User\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCash whereUserId($value)
 * @mixin \Eloquent
 */
class UserCash extends Base
{
  protected $fillable = [
    'user_id',
    'amount',
    'status'
  ];

  protected $casts = [
    'amount' => 'float',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
