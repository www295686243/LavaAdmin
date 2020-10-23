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
      $table->unsignedBigInteger('task_id')->comment('任务id');
      $table->string('title', 60)->comment('任务名');
      $table->string('task_recordable_type', 120)->nullable();
      $table->unsignedBigInteger('task_recordable_id')->nullable();
      $table->unsignedTinyInteger('task_type')->comment('任务类型(1全并且，2全或者，3阶梯式)');
      $table->json('rewards')->comment('任务奖励(同任务规则表)')->nullable();
      $table->unsignedTinyInteger('is_complete')->comment('是否完成任务')->default(0);
      $table->timestamp('task_end_time')->comment('任务结束时间')->nullable();
      $table->timestamp('task_complete_time')->comment('任务完成时间')->nullable();
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
