<?php

use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $userData = \App\Models\User::where('username', 'root')->first();
    $newsData = \App\Models\News::create([
      'text' => 'text',
      'user_id' => $userData->id
    ]);
  }
}
