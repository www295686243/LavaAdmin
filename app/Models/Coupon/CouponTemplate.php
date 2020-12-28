<?php

namespace App\Models\Coupon;

use App\Models\Base\Base;
use App\Models\User\UserCoupon;
use Illuminate\Support\Facades\DB;
use Kra8\Snowflake\Snowflake;

/**
 * App\Models\Coupon\CouponTemplate
 *
 * @property int|null|string $id
 * @property string $display_name 券名
 * @property string|null $desc 描述
 * @property int $is_trade 是否可交易
 * @property int|null $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_coupon_id
 * @property-read string $user_id
 * @property-read string $user_order_id
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTemplate whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTemplate whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTemplate whereIsTrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTemplate whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CouponTemplate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CouponTemplate extends Base
{
  protected $fillable = [
    'display_name',
    'desc',
    'is_trade',
    'sort'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  public static function bootHasSnowflakePrimary() {}

  /**
   * @param $idOrName
   * @return CouponTemplate|CouponTemplate[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
   */
  public static function getCouponTemplateData($idOrName)
  {
    $list = (new static())->cacheGetAll();
    if (is_numeric($idOrName)) {
      $data = $list->firstWhere('id', $idOrName);
    } else {
      $data = $list->firstWhere('display_name', $idOrName);
    }
    return $data;
  }

  /**
   * @param $user_id
   * @param $rewards
   * @param $source
   * @return string
   * @throws \Exception
   */
  public static function giveManyCoupons($user_id, $rewards, $source)
  {
    $giveCouponsText = '';
    $dot = '';
    foreach ($rewards as $reward) {
      $couponTemplateData = self::getCouponTemplateData($reward['coupon_template_id']);
      $couponTemplateData->giveCoupons($user_id, $reward['give_number'], $reward['amount'], $reward['expiry_day'], $source);
      $giveCouponsText .= $dot.$couponTemplateData->display_name.$reward['give_number'].'张';
      $dot = '、';
    }
    return $giveCouponsText;
  }

  /**
   * @param $user_id
   * @param $give_number
   * @param $amount
   * @param $expiry_day
   * @param $source
   * @throws \Exception
   */
  public function giveCoupons($user_id, $give_number, $amount, $expiry_day, $source)
  {
    $start_at = date('Y-m-d 00:00:00');
    $end_at = date('Y-m-d 05:00:00', strtotime('+'.$expiry_day.' day'));
    $currentDate = date('Y-m-d H:i:s');

    $data = [];
    for ($i = 0; $i < $give_number; $i++) {
      $data[] = [
        'id' => app(Snowflake::class)->next(),
        'user_id' => $user_id,
        'coupon_template_id' => $this->id,
        'display_name' => $this->display_name,
        'desc' => $this->desc,
        'amount' => $amount,
        'coupon_status' => UserCoupon::getCouponStatusValue(1, '未使用'),
        'start_at' => $start_at,
        'end_at' => $end_at,
        'source' => $source,
        'is_trade' => $this->is_trade,
        'created_at' => $currentDate,
        'updated_at' => $currentDate
      ];
    }
    DB::table('user_coupons')->insert($data);
  }
}
