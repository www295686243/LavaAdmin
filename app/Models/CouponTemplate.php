<?php

namespace App\Models;

use App\Models\User\UserCoupon;
use Illuminate\Support\Facades\DB;
use Kra8\Snowflake\Snowflake;

class CouponTemplate extends Base
{
  protected $fillable = [
    'display_name',
    'desc',
    'is_trade'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /**
   * @param $idOrName
   * @return CouponTemplate|CouponTemplate[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
   */
  public static function getCouponTemplateData($idOrName)
  {
    if (is_numeric($idOrName)) {
      $data = self::findOrFail($idOrName);
    } else {
      $data = self::where('name', $idOrName)->firstOrFail();
    }
    return $data;
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
        'coupon_status' => UserCoupon::getOptionsValue('coupon_status', '未使用'),
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
