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
    $data = [
      [
        'name' => 'app'
      ],
      [
        'name' => 'config'
      ]
    ];
    foreach ($data as $datum) {
      \App\Models\Version::create($datum);
    }
  }
}
