<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBillsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_bills', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->unsignedBigInteger('user_order_id')->nullable();
      $table->decimal('total_amount', 7,2 )->comment('总支付金额')->default(0);
      $table->decimal('cash_amount', 7, 2)->comment('现金金额')->default(0.00);
      $table->decimal('balance_amount', 7, 2)->comment('余额金额')->default(0.00);
      $table->decimal('coupon_amount', 7, 2)->comment('优惠券金额')->default(0.00);
      $table->string('desc')->comment('账单说明');
      $table->timestamps();

      $table->index('user_id');
      $table->index('user_order_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('user_bills');
  }
}
