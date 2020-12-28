<?php

namespace App\Models\User;

use App\Models\Base\Base;

/**
 * App\Models\User\UserBill
 *
 * @property int|null|string $id
 * @property string $user_id
 * @property string|null $user_billable_type
 * @property string|null $user_billable_id
 * @property float|null $total_amount 总支付金额
 * @property float|null $cash_amount 现金金额
 * @property float|null $balance_amount 余额金额
 * @property float|null $coupon_amount 优惠券金额
 * @property string $desc 账单说明
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \App\Models\User\User $user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $user_billable
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereBalanceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereCashAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereCouponAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereUserBillableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereUserBillableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserBill whereUserId($value)
 * @mixin \Eloquent
 */
class UserBill extends Base
{
  protected $fillable = [
    'user_id',
    'user_billable_type',
    'user_billable_id',
    'total_amount',
    'cash_amount',
    'balance_amount',
    'coupon_amount',
    'desc'
  ];

  protected $casts = [
    'total_amount' => 'float',
    'cash_amount' => 'float',
    'balance_amount' => 'float',
    'coupon_amount' => 'float',
    'user_billable_id' => 'string'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function user_billable()
  {
    return $this->morphTo();
  }
}
