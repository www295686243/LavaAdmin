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
    \App\Models\User::create([
      'username' => 'root',
      'nickname' => 'root',
      'password' => '111111'
    ]);
  }
}
