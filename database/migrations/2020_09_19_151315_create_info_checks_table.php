<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoChecksTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('info_checks', function (Blueprint $table) {
      $table->id();
      $table->string('info_checkable_type', 120);
      $table->unsignedBigInteger('info_checkable_id')->nullable();
      $table->string('info_title', 120)->comment('信息标题');
      $table->unsignedBigInteger('user_id')->comment('发布者');
      $table->json('contents')->comment('内容');
      $table->unsignedMediumInteger('status')->comment('状态(0待审核，1已审核，2未通过)')->default(0);
      $table->string('refuse_reason', 255)->comment('拒绝原因')->nullable();

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
    Schema::dropIfExists('info_checks');
  }
}
