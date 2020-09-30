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
      $table->unsignedBigInteger('task_id')->comment('任务id')->nullable();
      $table->unsignedBigInteger('task_rule_id')->comment('任务规则id')->nullable();
      $table->unsignedInteger('complete_number')->comment('完成次数')->default(0);
      $table->timestamps();

      $table->index('user_id');
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
