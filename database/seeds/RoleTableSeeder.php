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
      ]
    ];

    foreach ($data as $datum) {
      $role = \App\Models\Role::create($datum);
      $role->givePermissionTo(\App\Models\Permission::pluck('name'));
    }
  }
}
