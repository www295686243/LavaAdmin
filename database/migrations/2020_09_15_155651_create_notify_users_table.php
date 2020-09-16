<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifyUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('notify_users', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('notify_template_id')->comment('通知模板id');
      $table->unsignedBigInteger('user_id')->comment('发送用户');
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
    Schema::dropIfExists('notify_users');
  }
}
