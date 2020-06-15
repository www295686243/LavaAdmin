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
      ],
      [
        'name' => 'options',
        'display_name' => '选项',
        'value' => 1,
        'guard_name' => 'system'
      ]
    ];
    $children = [
      'options' => [
        [
          'display_name' => '选项1'
        ],
        [
          'display_name' => '选项2'
        ],
        [
          'display_name' => '选项3'
        ]
      ]
    ];
    foreach ($data as $datum) {
      $model = \App\Models\Config::create($datum);
      if (isset($children[$datum['name']])) {
        $model->options()->createMany($children[$datum['name']]);
      }
    }
  }
}
