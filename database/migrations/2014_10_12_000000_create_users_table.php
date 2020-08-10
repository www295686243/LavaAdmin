<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id('id');
      $table->unsignedBigInteger('invite_user_id')->comment('邀请人')->nullable();
      $table->string('nickname', 60)->nullable();
      $table->string('username', 30)->nullable();
      $table->string('email')->nullable();
      $table->string('phone')->nullable();
      $table->string('head_url', 255)->nullable();
      $table->unsignedInteger('city')->comment('当前所在地')->nullable();
      $table->unsignedTinyInteger('is_follow_official_account')->comment('是否关注公众号')->default(0);
      $table->string('follow_official_account_scene', 50)->comment('关注来源')->nullable();

      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->string('api_token')->nullable()->unique();
      $table->rememberToken();
      $table->unsignedTinyInteger('is_admin')->comment('是否管理员')->default(0);
      $table->timestamp('last_login_at')->comment('最后登录时间')->nullable();

      $table->timestamps();
      $table->softDeletes();

      $table->unique('username');
      $table->unique('phone');
      $table->unique('email');
      $table->index('city');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
