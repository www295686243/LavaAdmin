<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiLogsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // 差 操作系统 平台 屏幕宽度、高度 浏览器 浏览器版本
    Schema::create('api_logs', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('nickname', 30);
      $table->string('name', 120)->nullable();
      $table->string('method', 10);
      $table->string('path', 60);
      $table->string('ip', 20);
      $table->json('input')->nullable();
      $table->json('extra')->nullable();
      $table->string('status', 10)->comment('结果状态');
      $table->unsignedSmallInteger('code')->comment('状态码');
      $table->string('desc', 120)->comment('描述')->nullable();
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
    Schema::dropIfExists('api_logs');
  }
}
