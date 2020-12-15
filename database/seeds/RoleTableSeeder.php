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
        'platform' => 'admin'
      ],
      [
        'name' => 'Operations Manager',
        'display_name' => '运营经理',
        'menu_permissions' => \App\Models\AdminMenu::pluck('id'),
        'platform' => 'admin'
      ],
      [
        'name' => 'Technical Manager',
        'display_name' => '技术经理',
        'menu_permissions' => \App\Models\AdminMenu::pluck('id'),
        'platform' => 'admin'
      ],
      [
        'name' => 'Customer service Specialist',
        'display_name' => '客服专员',
        'platform' => 'admin'
      ],
      [
        'name' => 'Operation Specialist',
        'display_name' => '运营专员',
        'platform' => 'admin'
      ],
      [
        'name' => 'Information Specialist',
        'display_name' => '信息专员',
        'platform' => 'admin'
      ],
      [
        'name' => 'Finance Specialist',
        'display_name' => '财务专员',
        'platform' => 'admin'
      ],
      [
        'name' => 'Personal Member',
        'display_name' => '个人会员',
        'platform' => 'client'
      ],
      [
        'name' => 'Enterprise Member',
        'display_name' => '企业会员',
        'platform' => 'client'
      ],
      [
        'name' => 'Personal Auth',
        'display_name' => '个人认证',
        'platform' => 'client'
      ],
      [
        'name' => 'Enterprise Auth',
        'display_name' => '企业认证',
        'platform' => 'client'
      ],
      [
        'name' => 'VIP1 Member',
        'display_name' => 'VIP1',
        'platform' => 'client'
      ],
      [
        'name' => 'VIP2 Member',
        'display_name' => 'VIP2',
        'platform' => 'client'
      ],
      [
        'name' => 'VIP3 Member',
        'display_name' => 'VIP3',
        'platform' => 'client'
      ]
    ];

    foreach ($data as $datum) {
      $role = \App\Models\Role::create($datum);
      if ($role->display_name === '普通会员') {
        $role->syncPermissions(\App\Models\Permission::where('platform', 'api')->pluck('name'));
      }
    }
  }
}
