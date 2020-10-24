<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponOrdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('coupon_orders', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('user_id');
      $table->unsignedSmallInteger('quantity')->comment('购买张数');
      $table->decimal('total_amount', 8, 2)->comment('支付总金额');
      $table->unsignedTinyInteger('pay_status')->comment('状态(0未支付,1已支付,2已过期,3已放弃)')->default(0);
      $table->unsignedTinyInteger('payment')->comment('支付方式1微信支付2余额');
      $table->timestamp('paid_at')->comment('支付时间')->nullable();
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
    Schema::dropIfExists('coupon_orders');
  }
}
