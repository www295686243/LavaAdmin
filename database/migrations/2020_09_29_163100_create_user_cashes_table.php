<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCashesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_cashes', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->decimal('amount', 7, 2)->comment('提现金额');
      $table->unsignedTinyInteger('status')->comment('0占位1申请中2已通过3已拒绝4已撤回5已转款')->default(0);
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
    Schema::dropIfExists('user_cashes');
  }
}
