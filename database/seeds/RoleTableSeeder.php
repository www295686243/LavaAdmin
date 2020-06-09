<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
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
        'name' => 'root',
        'display_name' => 'Root',
        'guard_name' => 'admin'
      ],
      [
        'name' => 'super_admin',
        'display_name' => '超级管理员',
        'guard_name' => 'admin'
      ],
      [
        'name' => 'general_admin',
        'display_name' => '管理员',
        'guard_name' => 'admin'
      ]
    ];

    foreach ($data as $datum) {
      \App\Models\Role::create($datum);
    }
  }
}
