<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoComplaintsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('info_complaints', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('info_complaintable_type', 120);
      $table->unsignedBigInteger('info_complaintable_id')->nullable();
      $table->unsignedInteger('complaint_type')->comment('投诉类型')->default(0);
      $table->string('complaint_content', 255)->comment('投诉内容')->nullable();
      $table->string('handle_content', 255)->comment('处理结果')->nullable();
      $table->unsignedTinyInteger('is_solve')->comment('是否解决')->default(0);
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
    Schema::dropIfExists('info_complaints');
  }
}
