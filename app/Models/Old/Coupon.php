<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\Coupon
 *
 * @property int $id
 * @property int $coupon_template_id 互助券模板id
 * @property int $coupon_type 同互助券模板的字段类型
 * @property int $user_id 所属user_id
 * @property string $name 优惠券名称
 * @property string $desc 描述
 * @property string $amount 金额
 * @property int $status 状态(0未使用,1已使用,2已过期)
 * @property string|null $start_at 开始时间
 * @property string|null $end_at 过期时间
 * @property string $source 来源
 * @property int $is_trade 是否可交易
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCouponTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCouponType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereIsTrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUserId($value)
 * @mixin \Eloquent
 */
class Coupon extends Model
{
  protected $connection = 'zhizao';
}
