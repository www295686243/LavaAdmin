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
      $table->unsignedInteger('sell_user_id')->comment('出售人');
      $table->unsignedInteger('buy_user_id')->comment('购买人');
      $table->unsignedInteger('coupon_order_id');
      $table->unsignedInteger('user_coupon_id');
      $table->unsignedInteger('coupon_market_id');
      $table->decimal('amount', 6, 2)->comment('购买金额');
      $table->timestamps();

      $table->index('coupon_order_id');
      $table->index('coupon_id');
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
