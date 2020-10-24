<?php

namespace App\Jobs;

use App\Models\Coupon\CouponOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CouponOrderQueue implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $coupon_order_id;

  public $tries = 3;

  public $timeout = 300;

  /**
   * CouponOrderQueue constructor.
   * @param $coupon_order_id
   */
  public function __construct($coupon_order_id)
  {
    $this->coupon_order_id = $coupon_order_id;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $couponOrderData = CouponOrder::find($this->coupon_order_id);
    if ($couponOrderData && $couponOrderData->pay_status === CouponOrder::getPayStatusValue(1, '未支付')) {
      $couponOrderData->pay_status = CouponOrder::getPayStatusValue(3, '已过期');
      $couponOrderData->save();
      $couponOrderData->unlockCouponMarketData();
    }
  }
}
