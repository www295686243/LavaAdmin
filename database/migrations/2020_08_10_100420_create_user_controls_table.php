<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserControlsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_controls', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->unsignedTinyInteger('is_disable_all_push')->comment('是否关闭所有推送')->default(0);
      $table->unsignedTinyInteger('is_open_resume_push')->comment('是否开启简历推送')->default(1);
      $table->unsignedTinyInteger('is_open_job_push')->comment('是否开启职位推送')->default(1);
      $table->timestamps();
      $table->softDeletes();

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
    Schema::dropIfExists('user_controls');
  }
}
