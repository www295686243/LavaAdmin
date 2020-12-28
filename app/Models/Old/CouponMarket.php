<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Old\CouponMarket
 *
 * @property int $id
 * @property int $sell_user_id 出售人
 * @property int|null $buy_user_id 购买人
 * @property int $coupon_id 优惠券id
 * @property int $coupon_template_id 优惠券模板id
 * @property string $amount 出售价格
 * @property int $amount_sort 按金额排序
 * @property int $status 出售状态0出售中1待支付2已出售3已下架4已撤回
 * @property string|null $end_at 过期时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket query()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereAmountSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereBuyUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereCouponTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereSellUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponMarket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CouponMarket extends Model
{
  protected $connection = 'zhizao';
}
