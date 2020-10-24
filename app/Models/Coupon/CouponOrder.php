<?php

namespace App\Models\Coupon;

use App\Models\Base;
use App\Models\User\User;
use App\Models\User\UserAuth;
use App\Models\User\UserBill;
use Illuminate\Support\Facades\DB;

class CouponOrder extends Base
{
  protected $fillable = [
    'user_id',
    'quantity',
    'total_amount',
    'pay_status',
    'payment',
    'paid_at'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function coupon_order_sub()
  {
    return $this->hasMany(CouponOrderSub::class);
  }

  /**
   * @param \Illuminate\Support\Collection $couponMarketList
   * @return CouponOrder|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
   */
  public static function createOrder($couponMarketList)
  {
    $couponOrderData = self::query()->create([
      'user_id' => User::getUserId(),
      'quantity' => $couponMarketList->count(),
      'total_amount' => $couponMarketList->sum('amount'),
      'payment' => self::getOptionsValue('payment', 1, '微信')
    ]);

    $couponOrderSubSql = $couponMarketList->map(function ($item) use ($couponOrderData) {
      return [
        'sell_user_id' => $item->sell_user_id,
        'buy_user_id' => $couponOrderData->user_id,
        'coupon_order_id' => $couponOrderData->id,
        'user_coupon_id' => $item->user_coupon_id,
        'coupon_market_id' => $item->id,
        'amount' => $item->amount,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ];
    })->toArray();
    DB::table('coupon_order_subs')->insert($couponOrderSubSql);
    return $couponOrderData;
  }

  /**
   * @return mixed
   */
  public function getPayOrderConfig()
  {
    $app = app('wechat.payment');
    $userId = User::getUserId();
    $authData = UserAuth::where('user_id', $userId)->first();
    if (!$authData) {
      $this->error('该用户openId不存在');
    }
    $order = $app->order->unify([
      'body' => '购买通用券',
      'out_trade_no' => $this->id,
      'total_fee' => $this->total_amount * 100,
//      'total_fee' => 1,
      'trade_type' => 'JSAPI',
      'openid' => $authData->wx_openid,
      'notify_url' => env('APP_URL').'/api/coupon_market_pay_callback'
    ]);
    $data = $app->jssdk->sdkConfig($order['prepay_id']);
    return $data;
  }

  /**
   * 解锁交易市场的优惠券
   */
  public function unlockCouponMarketData()
  {
    $coupon_market_ids = $this->coupon_order_sub()->pluck('coupon_market_id');
    $CouponMarketList = CouponMarket::whereIn('id', $coupon_market_ids)
      ->where('status', CouponMarket::getStatusValue(2, '待支付'));
    if ($CouponMarketList->count() === count($coupon_market_ids)) {
      $CouponMarketList->update([
        'status' => CouponMarket::getStatusValue(1, '出售中')
      ]);
    }
  }

  /**
   * @param $value
   * @param $display_name
   * @return int
   */
  public static function getPayStatusValue($value, $display_name)
  {
    return static::getOptionsValue('pay_status', $value, $display_name);
  }

  /**
   * @param $desc
   * @return UserBill|\Illuminate\Database\Eloquent\Model
   */
  public function createUserBill($desc)
  {
    return UserBill::create([
      'user_id' => $this->user_id,
      'user_order_id' => $this->id,
      'total_amount' => -$this->total_amount,
      'desc' => $desc
    ]);
  }
}
