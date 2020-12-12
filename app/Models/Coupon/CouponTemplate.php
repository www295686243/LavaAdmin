<?php

namespace App\Models\Coupon;

use App\Models\Base\Base;
use App\Models\User\UserCoupon;
use Illuminate\Support\Facades\DB;
use Kra8\Snowflake\Snowflake;

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
