<?php

use Illuminate\Database\Seeder;

class NotifyTemplateTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \App\Models\Notify\NotifyTemplate::create([
      'template_id' => 1,
      'title' => '通知标题',
      'content' => '通知内容',
      'remark' => '通知备注',
      'url' => '/list',
      'url_params' => 'id',
      'keyword_names' => 'name,姓名',
      'is_push_official_account' => 1,
      'is_push_message' => 1
    ]);
  }
}
