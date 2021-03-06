<?php

use Illuminate\Database\Seeder;

class VersionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $data = [
      [
        'name' => 'app',
        'display_name' => '应用版本',
        'value' => 1
      ],
      [
        'name' => 'industry',
        'display_name' => '行业版本',
        'value' => 1
      ],
      [
        'name' => 'coupon_template',
        'display_name' => '优惠券版本',
        'value' => 1
      ],
      [
        'name' => 'task',
        'display_name' => '任务版本',
        'value' => 1
      ]
    ];
    foreach ($data as $datum) {
      \App\Models\Version::create($datum);
    }
  }
}
