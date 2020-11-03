<?php

namespace App\Observers;

use App\Models\Coupon\CouponTemplate;
use App\Models\Version;
use Illuminate\Support\Facades\Cache;

class CouponTemplateObserver
{
  /**
   * Handle the coupon template "created" event.
   *
   * @return void
   */
  public function created()
  {
    (new Version())->updateOrCreateVersion('coupon_template', '优惠券版本');
    Cache::tags(CouponTemplate::class)->forget((new CouponTemplate())->getTable());
  }

  /**
   * Handle the coupon template "updated" event.
   *
   * @return void
   */
  public function updated()
  {
    (new Version())->updateOrCreateVersion('coupon_template', '优惠券版本');
    Cache::tags(CouponTemplate::class)->forget((new CouponTemplate())->getTable());
  }

  /**
   * Handle the coupon template "deleted" event.
   *
   * @return void
   */
  public function deleted()
  {
    (new Version())->updateOrCreateVersion('coupon_template', '优惠券版本');
    Cache::tags(CouponTemplate::class)->forget((new CouponTemplate())->getTable());
  }
}
