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
      $table->decimal('amount', 8, 2)->comment('支付金额');
      $table->unsignedTinyInteger('pay_status')->comment('状态(0未支付,1已支付,2支付失败)')->default(0);
      $table->unsignedBigInteger('coupon_id')->comment('优惠券id')->nullable();
      $table->decimal('coupon_amount', 8, 2)->comment('优惠金额')->nullable();
      $table->unsignedTinyInteger('pay_type')->comment('支付类型1、查看联系方式');
      $table->timestamp('paid_at')->comment('支付时间')->nullable();
      $table->string('source', 20)->comment('支付来源')->nullable();
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
    Schema::dropIfExists('user_orders');
  }
}
