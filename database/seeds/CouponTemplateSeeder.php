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
    \App\Models\CouponTemplate::create([
      'display_name' => '优惠券',
      'desc' => '优惠券',
      'is_trade' => 1
    ]);
  }
}
