<?php

namespace App\Observers;

use App\Models\Coupon\CouponTemplate;
use App\Models\Version;

class CouponTemplateObserver
{
  /**
   * Handle the coupon template "created" event.
   *
   * @param  \App\Models\Coupon\CouponTemplate $couponTemplate
   * @return void
   */
  public function created(CouponTemplate $couponTemplate)
  {
    (new Version())->updateOrCreateVersion('coupon_template', '优惠券模板');
  }

  /**
   * Handle the coupon template "updated" event.
   *
   * @param  \App\Models\Coupon\CouponTemplate $couponTemplate
   * @return void
   */
  public function updated(CouponTemplate $couponTemplate)
  {
    (new Version())->updateOrCreateVersion('coupon_template', '优惠券模板');
  }

  /**
   * Handle the coupon template "deleted" event.
   *
   * @param  \App\Models\Coupon\CouponTemplate $couponTemplate
   * @return void
   */
  public function deleted(CouponTemplate $couponTemplate)
  {
    (new Version())->updateOrCreateVersion('coupon_template', '优惠券模板');
  }
}
