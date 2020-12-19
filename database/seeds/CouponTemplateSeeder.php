<?php

use Illuminate\Database\Seeder;

class CouponTemplateSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \App\Models\Coupon\CouponTemplate::create([
      'display_name' => '求职券',
      'desc' => '查看招聘信息一次'
    ]);
    \App\Models\Coupon\CouponTemplate::create([
      'display_name' => '招聘券',
      'desc' => '查看求职信息一次'
    ]);
    \App\Models\Coupon\CouponTemplate::create([
      'display_name' => '通用券',
      'desc' => '查看求职/招聘一次',
      'is_trade' => 1
    ]);
  }
}
