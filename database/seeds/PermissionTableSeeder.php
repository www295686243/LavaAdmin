<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
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
        'name' => 'UserController@getUserInfo',
        'display_name' => '获取',
        'guard_name' => 'admin'
      ]
    ];
    \App\Models\Permission::rebuildTree($data);
  }
}
