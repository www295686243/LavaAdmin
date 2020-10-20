<?php

use Illuminate\Database\Seeder;

class TaskTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $couponTemplateData = \App\Models\CouponTemplate::where('display_name', '优惠券')->first();
    $taskData = \App\Models\Task\Task::create([
      'title' => '分享任务',
      'desc' => '分享任务',
      'task_interface' => 'InfoViewController@store'
    ]);
    $taskData->task_rule()->create([
      'title' => '分享任务',
      'get_number' => 0,
      'rules' => [[["operator" => ">=", "rule_name" => "register_view", "target_number" => 1]]],
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $couponTemplateData->id]]
    ]);
  }
}
