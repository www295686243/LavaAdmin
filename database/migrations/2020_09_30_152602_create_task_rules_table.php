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
      $table->unsignedInteger('task_rule_name')->comment('任务规则标识(看配置表)');
      $table->string('operator', 10)->comment('任务条件(>=、>、=、<等等)');
      $table->unsignedInteger('target_number')->comment('目标数量')->default(0);
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
