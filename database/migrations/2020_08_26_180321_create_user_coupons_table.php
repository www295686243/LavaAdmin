<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCouponsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_coupons', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('coupon_template_id')->comment('互助券模板id');
      $table->unsignedBigInteger('user_id')->comment('所属user_id');
      $table->string('display_name', 60)->comment('券名');
      $table->string('desc', 255)->comment('描述')->nullable();
      $table->decimal('amount', 8, 2)->comment('金额');
      $table->unsignedTinyInteger('coupon_status')->comment('状态(0未使用,1已使用,2已过期,3挂售中,4已出售)')->default(0);
      $table->timestamp('start_at')->comment('开始时间')->nullable();
      $table->timestamp('end_at')->comment('过期时间')->nullable();
      $table->string('source', 60)->comment('来源');
      $table->unsignedTinyInteger('is_trade')->comment('是否可交易')->default(0);
      // created_at 发放时间
      // updated_at 使用时间
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
    Schema::dropIfExists('user_coupons');
  }
}
