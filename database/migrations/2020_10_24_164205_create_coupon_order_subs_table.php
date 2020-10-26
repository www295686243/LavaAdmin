<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponOrderSubsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('coupon_order_subs', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('sell_user_id')->comment('出售人');
      $table->unsignedBigInteger('buy_user_id')->comment('购买人');
      $table->unsignedBigInteger('coupon_order_id');
      $table->unsignedBigInteger('user_coupon_id');
      $table->unsignedBigInteger('coupon_market_id');
      $table->decimal('amount', 6, 2)->comment('购买金额');
      $table->timestamps();

      $table->index('coupon_order_id');
      $table->index('user_coupon_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('coupon_order_subs');
  }
}
