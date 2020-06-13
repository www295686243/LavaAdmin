<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLogsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('admin_logs', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('nickname', 30);
      $table->string('method', 10);
      $table->string('path', 60);
      $table->string('ip', 20);
      $table->json('input')->nullable();
      $table->string('status', 10)->comment('结果状态');
      $table->unsignedSmallInteger('code')->comment('状态码');
      $table->string('desc', 120)->comment('描述')->nullable();
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
    Schema::dropIfExists('admin_logs');
  }
}
