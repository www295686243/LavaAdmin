<?php

namespace App\Models\User;

use App\Models\Base\Base;

/**
 * App\Models\User\UserCoupon
 *
 * @property int|null|string $id
 * @property string $coupon_template_id 互助券模板id
 * @property string $user_id 所属user_id
 * @property string $display_name 券名
 * @property string|null $desc 描述
 * @property float $amount 金额
 * @property int $coupon_status 状态(0未使用,1已使用,2已过期,3挂售中,4已出售)
 * @property string|null $start_at 开始时间
 * @property \datetime|null $end_at 过期时间
 * @property string $source 来源
 * @property int $is_trade 是否可交易
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read bool $active
 * @property-read string $user_coupon_id
 * @property-read string $user_order_id
 * @property-read \App\Models\User\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereCouponStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereCouponTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereIsTrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCoupon whereUserId($value)
 * @mixin \Eloquent
 */
class UserCoupon extends Base
{
  protected $fillable = [
    'coupon_template_id',
    'user_id',
    'display_name',
    'desc',
    'amount',
    'coupon_status',
    'start_at',
    'end_at',
    'source',
    'is_trade'
  ];

  protected $casts = [
    'amount' => 'float',
    'end_at' => 'datetime:Y-m-d H:i',
    'coupon_template_id' => 'string'
  ];

  protected $appends = [
    'active'
  ];

  /**
   * @return bool
   */
  public function getActiveAttribute()
  {
    return false;
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @param $user_coupon_id
   * @return float
   */
  public function getUsableCouponAmount($user_coupon_id)
  {
    $userCouponData = null;
    if ($user_coupon_id) {
      $userCouponData = self::findOrFail($user_coupon_id);
      if ($userCouponData->coupon_status === UserCoupon::getCouponStatusValue(2, '已使用')) {
        $this->error('优惠券状态错误!');
      }
      $userCouponData->checkExpired();
      $userCouponData->coupon_status = UserCoupon::getCouponStatusValue(2, '已使用');
      $userCouponData->save();
    }
    return optional($userCouponData)->amount ?? 0;
  }

  /**
   * @return bool
   */
  public function checkExpired()
  {
    $currentDate = date('Y-m-d H:i:s');
    if ($this->start_at > $currentDate) {
      $this->error('该优惠券未到使用日期');
    }
    if ($currentDate > $this->end_at) {
      $this->error('该优惠券已过期');
    }
    return true;
  }

  /**
   * @param $value
   * @param $display_name
   * @return int
   */
  public static function getCouponStatusValue($value, $display_name)
  {
    return static::getOptionsValue('coupon_status', $value, $display_name);
  }
}
