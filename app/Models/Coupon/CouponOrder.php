<?php

namespace App\Models\Coupon;

use App\Models\Base\Base;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\User;
use App\Models\User\UserAuth;
use App\Models\User\UserBill;
use App\Models\User\UserCoupon;
use App\Models\User\UserWallet;
use Illuminate\Support\Facades\DB;
use Kra8\Snowflake\Snowflake;

class CouponOrder extends Base
{
  protected $fillable = [
    'user_id',
    'quantity',
    'total_amount',
    'pay_status',
    'payment',
    'paid_at',
    'remark'
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
      'pay_status' => self::getPayStatusValue(1, '未支付'),
      'payment' => self::getOptionsValue('payment', 1, '微信')
    ]);

    $couponOrderSubSql = $couponMarketList->map(function ($item) use ($couponOrderData) {
      return [
        'id' => app(Snowflake::class)->next(),
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
   * @return bool
   */
  public function getPayOrderConfig()
  {
    if (env('APP_ENV') === 'dev') {
      return true;
    }
    $app = app('wechat.payment');
    $userId = User::getUserId();
    $authData = UserAuth::where('user_id', $userId)->first();
    if (!$authData) {
      $this->error('该用户openId不存在');
    }
    $order = $app->order->unify([
      'body' => '购买通用券',
      'out_trade_no' => $this->id,
//      'total_fee' => $this->total_amount * 100,
      'total_fee' => 1,
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
      'cash_amount' => -$this->total_amount,
      'desc' => $desc
    ]);
  }

  public function actionAfterPay()
  {
    // 购买人账单
    $this->createUserBill('通用券购买');
    // 创建优惠券给购买人
    $couponOrderSubList = $this->coupon_order_sub()->with('user_coupon')->get();
    $couponSql = $couponOrderSubList->map(function ($couponOrderSubData) {
      return [
        'id' => app(Snowflake::class)->next(),
        'coupon_template_id' => $couponOrderSubData->user_coupon->coupon_template_id,
        'user_id' => $this->user_id,
        'display_name' => $couponOrderSubData->user_coupon->display_name,
        'desc' => $couponOrderSubData->user_coupon->desc,
        'amount' => $couponOrderSubData->user_coupon->amount,
        'coupon_status' => UserCoupon::getCouponStatusValue(1, '未使用'),
        'start_at' => $couponOrderSubData->user_coupon->start_at,
        'end_at' => $couponOrderSubData->user_coupon->end_at,
        'source' => '市场交易',
        'is_trade' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ];
    })->toArray();
    DB::table('user_coupons')->insert($couponSql);
    // 更新交易市场的优惠券状态
    $coupon_market_ids = $couponOrderSubList->pluck('coupon_market_id');
    $CouponMarketQuery = CouponMarket::with('user_coupon:id,display_name,amount')->whereIn('id', $coupon_market_ids);
    $CouponMarketQuery->update([
      'status' => CouponMarket::getStatusValue(3, '已出售'),
      'buy_user_id' => $this->user_id
    ]);
    // 更新优惠券表的状态
    $user_coupon_ids = $couponOrderSubList->pluck('user_coupon_id');
    UserCoupon::whereIn('id', $user_coupon_ids)->update(['coupon_status' => UserCoupon::getCouponStatusValue(5, '已出售')]);
    // 给出售人记录账单并入账
    $couponMarketList = $CouponMarketQuery->get();
    $userBillSql = [];
    foreach ($couponMarketList as $couponMarketData) {
      $userBillSql[] = [
        'id' => app(Snowflake::class)->next(),
        'user_id' => $couponMarketData->sell_user_id,
        'total_amount' => $couponMarketData->amount,
        'cash_amount' => $couponMarketData->amount,
        'desc' => $couponMarketData->user_coupon->amount.'元'.$couponMarketData->user_coupon->display_name.'出售',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ];
      $userBillSql[] = [
        'id' => app(Snowflake::class)->next(),
        'user_id' => $couponMarketData->sell_user_id,
        'total_amount' => -($couponMarketData->amount * 0.1),
        'cash_amount' => -($couponMarketData->amount * 0.1),
        'desc' => '手续费10%',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ];
      $sellUserWalletData = UserWallet::where('user_id', $couponMarketData->sell_user_id)->first();
      if ($sellUserWalletData) {
        $sellUserWalletData->increment('money', $couponMarketData->amount - ($couponMarketData->amount * 0.1));
        $sellUserWalletData->increment('total_earning', $couponMarketData->amount - ($couponMarketData->amount * 0.1));
        NotifyTemplate::send(37, '互助券出售成功通知', $couponMarketData->sell_user_id, [
          'nickname' => optional($couponMarketData->sell_user)->nickname,
          'couponFullName' => $couponMarketData->user_coupon->amount.'元'.$couponMarketData->user_coupon->display_name,
          'couponName' => $couponMarketData->user_coupon->display_name,
          'amount' => $couponMarketData->amount.'元',
          'datetime' => date('Y-m-d H:i:s'),
        ]);
      }
    }
    DB::table('user_bills')->insert($userBillSql);
  }
}
