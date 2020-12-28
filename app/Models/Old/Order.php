<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\Order
 *
 * @property int $id
 * @property int $order_id 订单id
 * @property int $user_id 支付者user_id
 * @property string $info_classify 类型
 * @property int $info_id 信息id
 * @property string $amount 支付金额
 * @property int $pay_status 状态(0未支付,1已支付)
 * @property int|null $coupon_id 优惠券id
 * @property string|null $coupon_amount 优惠金额
 * @property int $pay_type 支付类型1、查看联系方式
 * @property string|null $paid_at 支付时间
 * @property string|null $source 来源(delivery)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereInfoClassify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereInfoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
  protected $connection = 'zhizao';
}
