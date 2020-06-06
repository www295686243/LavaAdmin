<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsCaptchasTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('sms_captchas', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('phone', 20);
      $table->unsignedMediumInteger('code');
      $table->string('type_name')->comment('验证码类型');
      $table->unsignedTinyInteger('status')->comment('状态(0未验证，1已验证)')->default(0);
      $table->unsignedTinyInteger('result')->comment('发送结果(0未发送，1已发送, 2发送失败)')->default(0);

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
    Schema::dropIfExists('sms_captchas');
  }
}
