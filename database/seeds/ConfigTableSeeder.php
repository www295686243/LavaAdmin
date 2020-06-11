<?php

use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
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
        'name' => 'adminImageHost',
        'display_name' => '后台图片上传地址',
        'value' => 'image',
        'guard_name' => 'system'
      ],
      [
        'name' => 'adminFileHost',
        'display_name' => '后台文件上传地址',
        'value' => 'file',
        'guard_name' => 'system'
      ],
      [
        'name' => 'apiImageHost',
        'display_name' => '前台图片上传地址',
        'value' => 'image',
        'guard_name' => 'system'
      ],
      [
        'name' => 'apiFileHost',
        'display_name' => '前台文件上传地址',
        'value' => 'file',
        'guard_name' => 'system'
      ]
    ];
    foreach ($data as $datum) {
      \App\Models\Config::create($datum);
    }
  }
}
