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
      'desc' => '可查看招聘信息的联系方式'
    ]);
    \App\Models\Coupon\CouponTemplate::create([
      'display_name' => '招聘券',
      'desc' => '可查看求职信息的联系方式'
    ]);
    \App\Models\Coupon\CouponTemplate::create([
      'display_name' => '通用券',
      'desc' => '可查看招聘或求职信息的联系方式',
      'is_trade' => 1
    ]);
  }
}
