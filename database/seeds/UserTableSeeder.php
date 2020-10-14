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
      'nickname' => '万鑫',
      'password' => '111111'
    ]);
    $user->assignRole('General Member');
    $user2 = \App\Models\Api\User::createUser([
      'username' => 'wanxin2',
      'nickname' => '万鑫2',
      'password' => '111111'
    ]);
    $user2->assignRole('General Member');
  }
}
