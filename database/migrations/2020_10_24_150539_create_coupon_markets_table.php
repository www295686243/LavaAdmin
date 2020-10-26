<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponMarketsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('coupon_markets', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('sell_user_id')->comment('出售人');
      $table->unsignedBigInteger('buy_user_id')->comment('购买人')->nullable();
      $table->unsignedBigInteger('user_coupon_id')->comment('优惠券id');
      $table->unsignedBigInteger('coupon_template_id')->comment('优惠券模板id');
      $table->decimal('amount', 6, 2)->comment('出售价格');
      $table->unsignedInteger('amount_sort')->comment('按金额排序');
      $table->unsignedTinyInteger('status')->comment('出售状态0出售中1待支付2已出售3已下架4已撤回')->default(0);
      $table->timestamp('end_at')->comment('过期时间')->nullable();

      $table->timestamps();

      $table->index('sell_user_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('coupon_markets');
  }
}
