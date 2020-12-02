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
      'title' => '分享信息',
      'desc' => '1个新用户点击，即可获得1张互助券',
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 1, '通用任务'),
    ]);
    $taskData->task_rule()->createMany([
      [
        'title' => '分享简历',
        'operator' => '>=',
        'target_number' => 1,
        'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $hrJobCoupon->id]]
      ],
      [
        'title' => '分享职位',
        'operator' => '>=',
        'target_number' => 1,
        'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $hrResumeCoupon->id]]
      ]
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '关注公众号',
      'desc' => '首次关注公众号，奖励2张求职券和招聘券',
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 1, '通用任务'),
    ]);
    $taskData->task_rule()->create([
      'title' => '关注公众号',
      'operator' => '>=',
      'target_number' => 1,
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 2, "reward_name" => "coupon", "coupon_template_id" => $hrJobCoupon->id], ["amount" => 3, "expiry_day" => 30, "give_number" => 2, "reward_name" => "coupon", "coupon_template_id" => $hrResumeCoupon->id]]
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '绑定手机号',
      'desc' => '首次注册绑定手机号，奖励3张求职券和招聘券',
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 1, '通用任务'),
    ]);
    $taskData->task_rule()->create([
      'title' => '绑定手机号',
      'operator' => '>=',
      'target_number' => 1,
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 3, "reward_name" => "coupon", "coupon_template_id" => $hrJobCoupon->id], ["amount" => 3, "expiry_day" => 30, "give_number" => 3, "reward_name" => "coupon", "coupon_template_id" => $hrResumeCoupon->id]]
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '完善个人资料',
      'desc' => '奖励3张求职券',
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 2, '个人任务')
    ]);
    $taskData->task_rule()->create([
      'title' => '完善个人资料',
      'operator' => '>=',
      'target_number' => 1,
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 3, "reward_name" => "coupon", "coupon_template_id" => $hrJobCoupon->id]]
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '完善企业资料',
      'desc' => '奖励3张招聘券',
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 3, '企业任务')
    ]);
    $taskData->task_rule()->create([
      'title' => '完善企业资料',
      'operator' => '>=',
      'target_number' => 1,
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 3, "reward_name" => "coupon", "coupon_template_id" => $hrResumeCoupon->id]]
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '每天登录',
      'desc' => '发布简历并完善个人资料后每天登录奖励1张求职券',
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 2, '个人任务'),
    ]);
    $taskData->task_rule()->create([
      'title' => '个人每天登录',
      'operator' => '>=',
      'target_number' => 1,
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $hrJobCoupon->id]]
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '每天登录',
      'desc' => '发布职位并完善企业资料后每天登录奖励1张招聘券',
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 3, '企业任务')
    ]);
    $taskData->task_rule()->create([
      'title' => '企业每天登录',
      'operator' => '>=',
      'target_number' => 1,
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $hrResumeCoupon->id]]
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '邀请加入',
      'desc' => '邀请注册成功后获得1张通用券',
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 1, '通用任务'),
    ]);
    $taskData->task_rule()->create([
      'title' => '邀请加入',
      'operator' => '>=',
      'target_number' => 1,
      'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $hrCoupon->id]]
    ]);

    $taskData = \App\Models\Task\Task::create([
      'title' => '提供信息',
      'desc' => '提供职位或人才信息可获得通用券1张',
      'task_type' => \App\Models\Task\Task::getOptionsValue('task_type', 1, '通用任务'),
    ]);
    $taskData->task_rule()->createMany([
      [
        'title' => '提供职位',
        'operator' => '>=',
        'target_number' => 1,
        'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $hrCoupon->id]]
      ],
      [
        'title' => '提供人才',
        'operator' => '>=',
        'target_number' => 1,
        'rewards' => [["amount" => 3, "expiry_day" => 30, "give_number" => 1, "reward_name" => "coupon", "coupon_template_id" => $hrCoupon->id]]
      ]
    ]);
  }
}
