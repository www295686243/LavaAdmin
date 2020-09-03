<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOrdersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_orders', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id')->comment('支付者user_id');
      $table->string('user_orderable_type', 60);
      $table->unsignedBigInteger('user_orderable_id');
      $table->decimal('total_amount', 8, 2)->comment('总支付金额')->nullable();
      $table->decimal('cash_amount', 8, 2)->comment('现金金额')->nullable();
      $table->decimal('balance_amount', 8, 2)->comment('余额金额')->nullable();
      $table->decimal('coupon_amount', 8, 2)->comment('优惠券金额')->nullable();
      $table->unsignedBigInteger('user_coupon_id')->comment('用户的优惠券id')->nullable();
      $table->unsignedTinyInteger('pay_status')->comment('状态(0未支付,1已支付,2支付失败)')->default(0);
      $table->timestamp('paid_at')->comment('支付时间')->nullable();
      $table->string('source', 20)->comment('支付来源')->nullable();
      $table->timestamps();

      $table->index('user_id');
      $table->index('user_orderable_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('user_orders');
  }
}
