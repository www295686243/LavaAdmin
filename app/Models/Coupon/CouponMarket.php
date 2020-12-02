<?php

namespace App\Models\Coupon;

use App\Models\Base;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\User;
use App\Models\User\UserCoupon;

class CouponMarket extends Base
{
  protected $fillable = [
    'sell_user_id',
    'buy_user_id',
    'user_coupon_id',
    'coupon_template_id',
    'amount',
    'amount_sort',
    'status',
    'end_at'
  ];

  protected $casts = [
    'amount' => 'float',
    'end_at' => 'datetime:Y-m-d H:i'
  ];

  public function setAmountSortAttribute()
  {
    $this->attributes['amount_sort'] = intval($this->attributes['amount'] * 100);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function sell_user()
  {
    return $this->belongsTo(User::class, 'sell_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function buy_user()
  {
    return $this->belongsTo(User::class, 'buy_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user_coupon()
  {
    return $this->belongsTo(UserCoupon::class);
  }

  public function setExpiredCoupon()
  {
    $date = date('Y-m-d H:i:s', strtotime('-1 day'));
    $query = self::query()
      ->with(['user_coupon:id,display_name,amount', 'sell_user:id,nickname'])
      ->where('status', self::getStatusValue(1, '出售中'))
      ->where('end_at', '<', $date);
    $query->update(['status' => self::getStatusValue(4, '已下架')]);
    $query->get()->each(function ($item) {
      NotifyTemplate::sendAdmin(38, '互助券到期通知', [
        'nickname' => $item->sell_user->nickname,
        'couponFullName' => $item->user_coupon->amount.'元'.$item->user_coupon->display_name,
        'type' => self::getStatusLabel(1),
        'result' => self::getStatusLabel(4),
      ]);
    });
  }
}
