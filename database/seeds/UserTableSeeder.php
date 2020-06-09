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
      'password' => '111111'
    ]);
    $admin->assignRole(['super_admin']);
  }
}
