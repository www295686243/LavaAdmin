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
      $table->string('user_billable_type', 120)->nullable();
      $table->unsignedBigInteger('user_billable_id')->nullable();
      $table->decimal('total_amount', 7,2 )->comment('总支付金额')->nullable();
      $table->decimal('cash_amount', 7, 2)->comment('现金金额')->nullable();
      $table->decimal('balance_amount', 7, 2)->comment('余额金额')->nullable();
      $table->decimal('coupon_amount', 7, 2)->comment('优惠券金额')->nullable();
      $table->string('desc')->comment('账单说明');
      $table->timestamps();

      $table->index('user_id');
      $table->index('user_billable_id');
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
