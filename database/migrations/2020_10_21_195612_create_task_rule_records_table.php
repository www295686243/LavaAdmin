<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskRuleRecordsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('task_rule_records', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id')->comment('任务领取用户');
      $table->unsignedBigInteger('task_record_id')->comment('任务记录主表');
      $table->string('title', 60)->comment('任务名');
      $table->unsignedInteger('target_number')->comment('目标数量')->default(0);
      $table->unsignedInteger('complete_number')->comment('完成数量')->default(0);
      $table->json('rewards')->comment('任务奖励(同任务规则表)')->nullable();
      $table->unsignedTinyInteger('is_complete')->comment('是否完成任务')->default(0);
      $table->timestamp('task_complete_time')->comment('任务完成时间')->nullable();

      $table->timestamps();

      $table->index('task_record_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('task_rule_records');
  }
}
