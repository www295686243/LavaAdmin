<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
  /**
   * @throws Throwable
   */
  public function run()
  {
    $admin = \App\Models\Admin\User::createUser([
      'username' => 'root',
      'nickname' => 'root',
      'password' => '111111',
      'is_admin' => 1
    ]);
    $admin->assignRole('root');
    $admin2 = \App\Models\Admin\User::createUser([
      'username' => 'root2',
      'nickname' => 'root2',
      'password' => '111111',
      'is_admin' => 1
    ]);
    $admin2->assignRole('Operations Manager');

    $user = \App\Models\Api\User::createUser([
      'username' => 'wanxin',
      'nickname' => '招聘者',
      'password' => '111111',
//      'phone' => '11111111111'
    ]);
    $user->syncRoles(['General Member']);
    $user2 = \App\Models\Api\User::createUser([
      'username' => 'wanxin2',
      'nickname' => '求职者',
      'password' => '111111',
//      'phone' => '11111111112'
    ]);
    $user2->syncRoles(['General Member']);
  }
}
