<?php

use Illuminate\Database\Seeder;

class VersionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \App\Models\Version::create([
      'name' => 'app',
      'value' => '00.00.01'
    ]);
  }
}
