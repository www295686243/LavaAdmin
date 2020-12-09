<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPersonalAuthsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_personal_auths', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('name', 20)->comment('姓名')->nullable();
      $table->string('company', 60)->comment('公司名')->nullable();
      $table->string('position', 60)->comment('职位')->nullable();
      $table->unsignedInteger('city')->comment('省市区')->nullable();
      $table->string('address', 60)->comment('详细地址')->nullable();
      $table->string('intro', 255)->comment('简介')->nullable();
      // 格式['', '']
      $table->json('certificates')->comment('证件')->nullable();
      $table->unsignedMediumInteger('status')->comment('状态(0初始状态 1已提交 2已通过 3未通过)')->default(0);
      $table->string('refuse_reason', 255)->comment('拒绝原因')->nullable();
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
    Schema::dropIfExists('user_personal_auths');
  }
}
