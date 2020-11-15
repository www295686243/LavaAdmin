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
        'name' => 'Operations Manager',
        'display_name' => '运营经理',
        'menu_permissions' => \App\Models\AdminMenu::pluck('id'),
        'guard_name' => 'admin'
      ],
      [
        'name' => 'Customer service Specialist',
        'display_name' => '客服专员',
        'guard_name' => 'admin'
      ],
      [
        'name' => 'Operation Specialist',
        'display_name' => '运营专员',
        'guard_name' => 'admin'
      ],
      [
        'name' => 'General Member',
        'display_name' => '普通会员',
        'guard_name' => 'api'
      ],
      [
        'name' => 'Personal Member',
        'display_name' => '个人会员',
        'guard_name' => 'api'
      ],
      [
        'name' => 'Enterprise Member',
        'display_name' => '企业会员',
        'guard_name' => 'api'
      ],
      [
        'name' => 'Personal Auth',
        'display_name' => '个人认证',
        'guard_name' => 'api'
      ],
      [
        'name' => 'Enterprise Auth',
        'display_name' => '企业认证',
        'guard_name' => 'api'
      ]
    ];

    foreach ($data as $datum) {
      $role = \App\Models\Role::create($datum);
      if ($role->display_name === '普通会员') {
        $role->syncPermissions(\App\Models\Permission::where('guard_name', 'api')->pluck('name'));
      }
    }
  }
}
