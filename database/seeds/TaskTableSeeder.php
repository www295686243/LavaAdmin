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
    $couponTemplateData = \App\Models\Coupon\CouponTemplate::where('display_name', '优惠券')->first();
    $taskData = \App\Models\Task\Task::create([
      'title' => '分享任务',
      'desc' => '分享任务',
      'task_name' => \App\Models\Task\Task::getOptionsValue('task_name', 1, '分享任务'),
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 3, '阶梯任务')
    ]);
    $taskData->task_rule()->create([
      'task_rule_name' => \App\Models\Task\TaskRule::getOptionsValue('task_rule_name', 1, '新用户访问'),
      'operator' => '>=',
      'target_number' => 1,
      'task_interface' => 'Api\Info\InfoViewController@store',
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $couponTemplateData->id]]
    ]);
  }
}
