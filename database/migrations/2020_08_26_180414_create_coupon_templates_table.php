<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponTemplatesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('coupon_templates', function (Blueprint $table) {
      $table->id();
      $table->string('display_name', 60)->comment('券名');
      $table->string('desc', 255)->comment('描述')->nullable();
      $table->unsignedTinyInteger('is_trade')->comment('是否可交易')->default(0);
      $table->unsignedInteger('sort')->comment('排序')->nullable();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('coupon_templates');
  }
}
