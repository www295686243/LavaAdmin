<?php

namespace App\Models\User;

use App\Models\ApiLog;
use App\Models\Base\Base;
use Illuminate\Support\Str;

/**
 * App\Models\User\UserOrder
 *
 * @property int|null|string $id 主键/订单id
 * @property string $user_id 支付者user_id
 * @property string $user_orderable_type
 * @property string $user_orderable_id
 * @property float|null $total_amount 总支付金额
 * @property float|null $cash_amount 现金金额
 * @property float|null $balance_amount 余额金额
 * @property float|null $coupon_amount 优惠券金额
 * @property string $user_coupon_id 用户的优惠券id
 * @property int $pay_status 状态(0未支付,1已支付,2支付失败)
 * @property string|null $paid_at 支付时间
 * @property string|null $source 支付来源
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $user_order_id
 * @property-read \App\Models\User\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User\UserBill[] $user_bill
 * @property-read int|null $user_bill_count
 * @property-read \App\Models\User\UserCoupon|null $user_coupon
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $user_orderable
 * @method static \Illuminate\Database\Eloquent\Builder|Base listQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base pagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchModel($typeField, $model = '')
 * @method static \Illuminate\Database\Eloquent\Builder|Base searchQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Base simplePagination()
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereBalanceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereCashAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereCouponAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder wherePayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereUserCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereUserOrderableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserOrder whereUserOrderableType($value)
 * @mixin \Eloquent
 */
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
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function user_bill()
  {
    return $this->morphMany(UserBill::class, 'user_billable');
  }

  /**
   * @param $desc
   * @return UserBill|\Illuminate\Database\Eloquent\Model
   */
  public function createUserBill($desc)
  {
    return $this->user_bill()->create([
      'user_id' => $this->user_id,
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
    $className = class_basename($this->user_orderable_type);
    $snakeType = Str::snake($className);
    return env('APP_URL').'/api/'.$snakeType.'/pay_callback';
  }
}
