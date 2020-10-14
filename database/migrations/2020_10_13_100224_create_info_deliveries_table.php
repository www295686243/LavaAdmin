<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoDeliveriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('info_deliveries', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('send_user_id');
      $table->string('send_info_type', 120);
      $table->unsignedBigInteger('send_info_id');
      $table->unsignedBigInteger('receive_user_id');
      $table->string('receive_info_type', 120);
      $table->unsignedBigInteger('receive_info_id');
      $table->unsignedBigInteger('order_id')->nullable();
      $table->timestamps();

      $table->index('send_user_id');
      $table->index('receive_user_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('info_deliveries');
  }
}
