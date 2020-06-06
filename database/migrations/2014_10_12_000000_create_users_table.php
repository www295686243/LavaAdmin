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
      $table->string('nickname')->comment('昵称')->nullable();
      $table->string('username')->comment('用户名')->nullable();
      $table->string('email')->nullable()->unique();
      $table->string('phone')->nullable()->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->decimal('money', 9, 2)->comment('金额')->default(0);
      $table->rememberToken();
      $table->unsignedTinyInteger('is_admin')->comment('是否管理员')->default(0);

      $table->timestamps();
      $table->softDeletes();
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
