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
    $hrJobCoupon = \App\Models\Coupon\CouponTemplate::where('display_name', '求职券')->first();
    $hrResumeCoupon = \App\Models\Coupon\CouponTemplate::where('display_name', '招聘券')->first();
    $hrCoupon = \App\Models\Coupon\CouponTemplate::where('display_name', '通用券')->first();
    $taskData = \App\Models\Task\Task::create([
      'title' => '信息分享',
      'desc' => '分享信息后被1个新用户查看获得1张通用券',
      'task_name' => \App\Models\Task\Task::getOptionsValue('task_name', 1, '分享任务'),
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 1, '联合任务'),
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $hrJobCoupon->id]]
    ]);
    $taskData->task_rule()->create([
      'task_rule_name' => \App\Models\Task\TaskRule::getOptionsValue('task_rule_name', 1, '新用户访问'),
      'operator' => '>=',
      'target_number' => 1,
      'task_interface' => 'Api\Info\InfoViewController@store'
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '关注公众号',
      'desc' => '首次关注公众号，奖励2张求职券和招聘券',
      'task_name' => \App\Models\Task\Task::getOptionsValue('task_name', 2, '关注公众号'),
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 1, '联合任务'),
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 2, "reward_name" => "coupon", "coupon_template_id" => $hrJobCoupon->id], ["amount" => 3, "expiry_day" => 30, "give_number" => 2, "reward_name" => "coupon", "coupon_template_id" => $hrResumeCoupon->id]]
    ]);
    $taskData->task_rule()->create([
      'task_rule_name' => \App\Models\Task\TaskRule::getOptionsValue('task_rule_name', 3, '关注公众号'),
      'operator' => '>=',
      'target_number' => 1
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '绑定手机号',
      'desc' => '首次注册绑定手机号，奖励3张求职券和招聘券',
      'task_name' => \App\Models\Task\Task::getOptionsValue('task_name', 3, '绑定手机号'),
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 1, '联合任务'),
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 3, "reward_name" => "coupon", "coupon_template_id" => $hrJobCoupon->id], ["amount" => 3, "expiry_day" => 30, "give_number" => 3, "reward_name" => "coupon", "coupon_template_id" => $hrResumeCoupon->id]]
    ]);
    $taskData->task_rule()->create([
      'task_rule_name' => \App\Models\Task\TaskRule::getOptionsValue('task_rule_name', 4, '绑定手机号'),
      'operator' => '>=',
      'target_number' => 1,
      'task_interface' => 'Api\User\UserController@bindPhone'
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '完善个人简历资料',
      'desc' => '完善个人简历资料，奖励3张求职券',
      'task_name' => \App\Models\Task\Task::getOptionsValue('task_name', 4, '完善个人简历资料'),
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 1, '联合任务'),
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 3, "reward_name" => "coupon", "coupon_template_id" => $hrJobCoupon->id]]
    ]);
    $taskData->task_rule()->create([
      'task_rule_name' => \App\Models\Task\TaskRule::getOptionsValue('task_rule_name', 5, '完善个人简历资料'),
      'operator' => '>=',
      'target_number' => 1,
      'task_interface' => 'Admin\Info\InfoCheckController@update'
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '企业每天登录',
      'desc' => '每天首次登录，奖励1张招聘券',
      'task_name' => \App\Models\Task\Task::getOptionsValue('task_name', 5, '企业每天登录'),
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 1, '联合任务'),
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $hrJobCoupon->id]]
    ]);
    $taskData->task_rule()->create([
      'task_rule_name' => \App\Models\Task\TaskRule::getOptionsValue('task_rule_name', 6, '企业每天登录'),
      'operator' => '>=',
      'target_number' => 1,
      'task_interface' => 'Api\User\UserController@todayFirstLogin'
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '个人每天登录',
      'desc' => '每天首次登录，奖励1张求职券',
      'task_name' => \App\Models\Task\Task::getOptionsValue('task_name', 6, '个人每天登录'),
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 1, '联合任务'),
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $hrResumeCoupon->id]]
    ]);
    $taskData->task_rule()->create([
      'task_rule_name' => \App\Models\Task\TaskRule::getOptionsValue('task_rule_name', 7, '个人每天登录'),
      'operator' => '>=',
      'target_number' => 1,
      'task_interface' => 'Api\User\UserController@todayFirstLogin'
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '邀请加入',
      'desc' => '邀请注册成功后获得1张通用券',
      'task_name' => \App\Models\Task\Task::getOptionsValue('task_name', 7, '邀请加入'),
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 1, '联合任务'),
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $hrCoupon->id]]
    ]);
    $taskData->task_rule()->create([
      'task_rule_name' => \App\Models\Task\TaskRule::getOptionsValue('task_rule_name', 8, '邀请加入'),
      'operator' => '>=',
      'target_number' => 1,
      'task_interface' => 'Api\User\UserController@setInviteUser'
    ]);
  }
}
