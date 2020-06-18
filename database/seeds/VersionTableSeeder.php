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
        'display_name' => '应用版本'
      ],
      [
        'name' => 'config',
        'display_name' => '全局配置'
      ]
    ];
    foreach ($data as $datum) {
      \App\Models\Version::create($datum);
    }
  }
}
