<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskRulesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('task_rules', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('task_id')->comment('任务id');
      $table->string('title', 60)->nullable();
      $table->unsignedSmallInteger('get_number')->comment('领取次数')->default(1);
      /**
       * 需要支持 且运算 与 或运算的情况
       * 且运算格式：[{xxx, xxx, xxx}, {xxx, xxx, xxx}]
       * 或运算格式：[[{xxx, xxx, xxx}, {xxx, xxx, xxx}]]
       * 且与或的组合：[{xxx, xxx, xxx}, [{xxx, xxx, xxx}, {xxx, xxx, xxx}]]
       * 对象内的字段：
       * rule_name 规则类型(标识)：register-view:新用户查看, view:用户查看
       * operator 规则限制(例如：>=/>/=/<等等)
       * target_number 目标数量
       */
      $table->json('rules')->comment('任务规则');
      /**
       * 格式：[{xxx, xxx, xxx}, {xxx, xxx, xxx}]
       * 对象内的字段：
       * reward_name: 奖励类型(标识)，coupon:优惠券
       * give_number 奖励数量
       * coupon_template_id 优惠券模板
       * amount 优惠券金额
       * expiry_day 优惠券有效期多少天
       */
      $table->json('rewards')->comment('任务奖励');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('task_rules');
  }
}
