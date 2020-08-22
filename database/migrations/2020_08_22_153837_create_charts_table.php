<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('charts', function (Blueprint $table) {
      $table->id();
      $table->date('stat_date')->comment('统计日期');
      $table->json('stat_data')->comment('统计数据');
      $table->timestamps();

      $table->index('stat_date');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('charts');
  }
}
