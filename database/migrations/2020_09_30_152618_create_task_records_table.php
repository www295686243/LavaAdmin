<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskRecordsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('task_records', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id')->comment('任务领取用户');
      $table->string('task_recordable_type', 120)->nullable();
      $table->unsignedBigInteger('task_recordable_id')->nullable();
      $table->unsignedBigInteger('task_id')->comment('任务id')->nullable();
      $table->json('rules')->comment('任务规则(同任务规则表)');
      $table->json('rewards')->comment('任务奖励(同任务规则表)');
      $table->unsignedBigInteger('task_rule_id')->comment('任务规则id')->nullable();
      $table->unsignedTinyInteger('is_complete')->comment('是否完成任务')->default(0);
      $table->timestamps();

      $table->index('user_id');
      $table->index('task_id');
      $table->index('task_recordable_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('task_records');
  }
}
