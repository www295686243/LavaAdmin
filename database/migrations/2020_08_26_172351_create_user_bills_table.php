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
      $table->decimal('amount', 7,2 );
      $table->unsignedTinyInteger('amount_type')->comment('金额类型0占位1现金2余额')->default(0);
      $table->string('desc')->comment('账单说明');
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
    Schema::dropIfExists('user_bills');
  }
}
