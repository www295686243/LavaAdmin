<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
  /**
   * @throws Throwable
   */
  public function run()
  {
    $admin = \App\Models\User\User::createUser([
      'username' => 'root',
      'nickname' => 'root',
      'password' => '111111',
      'is_admin' => 1
    ]);
    $admin->assignRole('root');
    $admin2 = \App\Models\User\User::createUser([
      'username' => 'root2',
      'nickname' => 'root2',
      'password' => '111111',
      'is_admin' => 1
    ]);
    $admin2->assignRole('Operations Manager');

    $user = \App\Models\User\User::createUser([
      'username' => 'wanxin',
      'nickname' => '招聘者',
      'password' => '111111',
      'current_role' => 'Personal Member'
    ]);
    $user->syncRoles(['Personal Member']);
    \App\Models\User\UserPersonal::updateInfo([
      'industry' => [17, 18],
      'city' => 440104
    ], $user->id);
    \App\Models\User\User::createUser([
      'username' => 'wanxin2',
      'nickname' => '求职者',
      'password' => '111111',
    ]);
  }
}
