<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAuthsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_auths', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id')->comment('关联的用户id');
      $table->string('wx_openid', 60)->comment('微信用户唯一id')->nullable();
      $table->string('wx_unionid', 60)->comment('微信跨平台登录id')->nullable();
      $table->timestamps();
      $table->softDeletes();

      $table->index('wx_openid');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('user_auths');
  }
}
