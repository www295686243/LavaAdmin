<?php

namespace App\Models\User;

use App\Models\ApiLog;
use App\Models\Base;
use Kra8\Snowflake\HasSnowflakePrimary;

class UserOrder extends Base
{
  use HasSnowflakePrimary;
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
    $this->pay_status = self::getOptionsValue('pay_status', '已支付');
    $this->paid_at = date('Y-m-d H:i:s');
    $this->save();
    if (request()->getPathInfo() === '/api/wechat/pay_callback') {
      (new ApiLog())->createLog([
        'status' => 'success',
        'code' => 200,
        'desc' => '支付成功',
        'data' => [
          'user_id' => $this->user_id
        ]
      ]);
    }
  }

  public function payFail()
  {
    $this->pay_status = self::getOptionsValue('pay_status', '支付失败');
    $this->save();
    if (request()->getPathInfo() === '/api/wechat/pay_callback') {
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
}
