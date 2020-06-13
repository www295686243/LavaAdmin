<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $admin = \App\Models\Admin\User::create([
      'username' => 'root',
      'nickname' => 'root',
      'password' => '111111',
      'is_admin' => 1
    ]);
    $admin->assignRole('root');
    $admin2 = \App\Models\Admin\User::create([
      'username' => 'root2',
      'nickname' => 'root2',
      'password' => '111111',
      'is_admin' => 1
    ]);
    $admin2->assignRole('Operations Manager');
  }
}
