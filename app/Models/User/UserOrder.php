<?php

namespace App\Models\User;

use App\Models\ApiLog;
use App\Models\Base\Base;
use Illuminate\Support\Str;

class UserOrder extends Base
{
  protected $fillable = [
    'user_id',
    'user_orderable_type',
    'user_orderable_id',
    'total_amount',
    'cash_amount',
    'balance_amount',
    'coupon_amount',
    'user_coupon_id',
    'pay_status',
    'paid_at',
    'source'
  ];

  protected $casts = [
    'total_amount' => 'float',
    'cash_amount' => 'float',
    'balance_amount' => 'float',
    'coupon_amount' => 'float',
    'user_orderable_id' => 'string'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user_coupon()
  {
    return $this->belongsTo(UserCoupon::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function user_orderable()
  {
    return $this->morphTo();
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
      'cash_amount' => -$this->cash_amount,
      'balance_amount' => -$this->balance_amount,
      'coupon_amount' => -$this->coupon_amount,
      'desc' => $desc
    ]);
  }

  public function paySuccess()
  {
    $this->pay_status = self::getPayStatusValue(2, '已支付');
    $this->paid_at = date('Y-m-d H:i:s');
    $this->save();
    if (Str::contains(request()->getPathInfo(), 'pay_callback')) {
      (new ApiLog())->createLog([
        'status' => 'success',
        'code' => 200,
        'desc' => '支付成功',
        'data' => [
          'user_id' => $this->user_id
        ],
        'extra' => [
          'isFirstPay' => $this->isFirstPay(),
          'isModelFirstPay' => $this->isModelFirstPay()
        ]
      ]);
    }
  }

  public function payFail()
  {
    $this->pay_status = self::getPayStatusValue(3, '支付失败');
    $this->save();
    if (Str::contains(request()->getPathInfo(), 'pay_callback')) {
      (new ApiLog())->createLog([
        'status' => 'error',
        'code' => 200,
        'desc' => '支付失败',
        'data' => [
          'user_id' => $this->user_id
        ]
      ]);
    }
  }

  /**
   * @return bool
   */
  public function isFirstPay()
  {
    $count = self::where('user_id', $this->user_id)->where('pay_status', self::getPayStatusValue(2, '已支付'))->count();
    return $count === 1;
  }

  /**
   * @return bool
   */
  public function isModelFirstPay()
  {
    $count = self::where('user_id', $this->user_id)
      ->where('user_orderable_type', $this->user_orderable_type)
      ->where('pay_status', self::getPayStatusValue(2, '已支付'))
      ->count();
    return $count === 1;
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
   * 退款
   */
  public function modelRefund()
  {
    if ($this->user_coupon_id) {
      $couponData = UserCoupon::find($this->user_coupon_id);
      if ($couponData) {
        $couponData->coupon_status = UserCoupon::getCouponStatusValue(1, '未使用');
        $couponData->save();
      }
    }
    if ($this->cash_amount || $this->balance_amount) {
      $totalAmount = $this->cash_amount + $this->balance_amount;
      (new UserWallet())->incrementAmount($totalAmount, $this->user_id);

      UserBill::create([
        'user_id' => $this->user_id,
        'user_order_id' => $this->id,
        'total_amount' => $totalAmount,
        'balance_amount' => $totalAmount,
        'desc' => '退款'
      ]);
    }
  }

  /**
   * @return mixed
   * @throws \Exception
   */
  public function modelGetPayConfig()
  {
    if (env('APP_ENV') === 'dev') {
      return [];
    }
    $userAuthData = UserAuth::where('user_id', $this->user_id)->first();
    if (!$userAuthData || !$userAuthData->wx_openid) {
      throw new \Exception('openid不存在');
    }
    $app = app('wechat.payment');
    $order = $app->order->unify([
      'body' => '查看联系方式',
      'out_trade_no' => $this->id,
      'total_fee' => 1,
//      'total_fee' => $this->total_amount * 100,
      'trade_type' => 'JSAPI',
      'openid' => $userAuthData->wx_openid,
      'notify_url' => $this->getNotifyUrl()
    ]);
    $config = $app->jssdk->sdkConfig($order['prepay_id']);
    return $config;
  }

  /**
   * @return string
   */
  private function getNotifyUrl () {
    $snakeType = Str::of($this->user_orderable_type)->basename()->snake();
    \Log::info(env('APP_URL').'/api/'.$snakeType.'/pay_callback');
    return env('APP_URL').'/api/'.$snakeType.'/pay_callback';
  }
}
