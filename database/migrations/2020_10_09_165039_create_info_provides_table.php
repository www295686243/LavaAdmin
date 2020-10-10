<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoProvidesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('info_provides', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('description', 255);
      $table->string('phone', 18);
      $table->unsignedInteger('status')->comment('0待审核1已发布2中介3已招到4面试中5不需要6未接通7电话错8态度差')->default(0);
      $table->string('info_provideable_type', 120);
      $table->unsignedBigInteger('info_provideable_id')->nullable();
      $table->unsignedBigInteger('admin_user_id')->comment('信息归属人，用于查看是后台哪个账户操作的')->nullable();
      $table->unsignedTinyInteger('is_admin')->comment('是否管理员发布的')->default(0);
      $table->unsignedTinyInteger('is_reward')->comment('是否奖励过')->default(0);
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
    Schema::dropIfExists('info_provides');
  }
}
