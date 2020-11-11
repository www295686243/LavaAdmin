<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tasks', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('task_name')->comment('任务标识(看配置表)');
      $table->string('title', 60)->comment('任务标题');
      $table->string('desc', 255)->comment('任务描述');
      $table->unsignedTinyInteger('task_mode')->comment('任务模式(看配置表)');
      $table->unsignedTinyInteger('task_type')->comment('任务类型(看配置表)');
      /**
       * 格式：[{xxx, xxx, xxx}, {xxx, xxx, xxx}]
       * 对象内的字段：
       * reward_name: 奖励类型(标识)，coupon:优惠券
       * give_number 奖励数量
       * coupon_template_id 优惠券模板
       * amount 优惠券金额
       * expiry_day 优惠券有效期多少天
       */
      $table->json('rewards')->comment('任务奖励')->nullable();
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
    Schema::dropIfExists('tasks');
  }
}
