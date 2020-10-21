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
      $table->unsignedInteger('task_rule_name')->comment('任务规则(看配置表)');
      $table->string('operator', 10)->comment('任务条件(>=、>、=、<等等)');
      $table->unsignedInteger('target_number')->comment('目标数量')->default(0);
      $table->unsignedInteger('complete_number')->comment('完成数量')->default(0);
      $table->json('rewards')->comment('任务奖励(同任务规则表)')->nullable();

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
