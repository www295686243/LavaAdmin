<?php

namespace App\Models\Coupon;

use App\Models\Base\Base;
use App\Models\User\User;
use App\Models\User\UserCoupon;

/**
 * App\Models\Coupon\CouponOrderSub
 *
 * @property int|null|string $id
 * @property int $sell_user_id 出售人
 * @property int $buy_user_id 购买人
 * @property int $coupon_order_id
 * @property string $user_coupon_id
 * @property int $coupon_market_id
 * @property string $amount 购买金额
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User $buy_user
 * @property-read string $user_id
 * @property-read string $user_order_id
 * @property-read User $sell_user
 * @property-read UserCoupon $user_coupon
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponOrderSub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponOrderSub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponOrderSub query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponOrderSub whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponOrderSub whereBuyUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponOrderSub whereCouponMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponOrderSub whereCouponOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponOrderSub whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponOrderSub whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponOrderSub whereSellUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponOrderSub whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponOrderSub whereUserCouponId($value)
 * @mixin \Eloquent
 */
class CouponOrderSub extends Base
{
  protected $fillable = [
    'sell_user_id',
    'buy_user_id',
    'coupon_order_id',
    'user_coupon_id',
    'coupon_market_id',
    'amount'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user_coupon()
  {
    return $this->belongsTo(UserCoupon::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function sell_user()
  {
    return $this->belongsTo(User::class, 'sell_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function buy_user()
  {
    return $this->belongsTo(User::class, 'buy_user_id');
  }
}
