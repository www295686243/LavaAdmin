<?php

namespace App\Models\Coupon;

use App\Models\Base\Base;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\User;
use App\Models\User\UserCoupon;

/**
 * App\Models\Coupon\CouponMarket
 *
 * @property int|null|string $id
 * @property int $sell_user_id 出售人
 * @property int|null $buy_user_id 购买人
 * @property string $user_coupon_id 优惠券id
 * @property int $coupon_template_id 优惠券模板id
 * @property float $amount 出售价格
 * @property int $amount_sort 按金额排序
 * @property int $status 出售状态0出售中1待支付2已出售3已下架4已撤回
 * @property \datetime|null $end_at 过期时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $buy_user
 * @property-read string $user_id
 * @property-read string $user_order_id
 * @property-read User $sell_user
 * @property-read UserCoupon $user_coupon
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereAmountSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereBuyUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereCouponTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereSellUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereUserCouponId($value)
 * @mixin \Eloquent
 */
class CouponMarket extends Base
{
  protected $fillable = [
    'sell_user_id',
    'buy_user_id',
    'user_coupon_id',
    'coupon_template_id',
    'amount',
    'amount_sort',
    'status',
    'end_at'
  ];

  protected $casts = [
    'amount' => 'float',
    'end_at' => 'datetime:Y-m-d H:i'
  ];

  public function setAmountSortAttribute()
  {
    $this->attributes['amount_sort'] = intval($this->attributes['amount'] * 100);
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

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user_coupon()
  {
    return $this->belongsTo(UserCoupon::class);
  }

  public function setExpiredCoupon()
  {
    $date = date('Y-m-d H:i:s', strtotime('-1 day'));
    $query = self::query()
      ->with(['user_coupon:id,display_name,amount', 'sell_user:id,nickname'])
      ->where('status', self::getStatusValue(1, '出售中'))
      ->where('end_at', '<', $date);
    $query->update(['status' => self::getStatusValue(4, '已下架')]);
    $query->get()->each(function ($item) {
      NotifyTemplate::send(38, '互助券到期通知', $item->sell_user, [
        'nickname' => $item->sell_user->nickname,
        'couponFullName' => $item->user_coupon->amount.'元'.$item->user_coupon->display_name,
        'type' => self::getStatusLabel(1),
        'result' => self::getStatusLabel(4),
      ]);
    });
  }
}
