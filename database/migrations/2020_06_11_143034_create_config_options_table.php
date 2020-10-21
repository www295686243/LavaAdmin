<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigOptionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('config_options', function (Blueprint $table) {
      $table->id('id');
      $table->string('name', 120)->comment('标识')->nullable();
      $table->unsignedBigInteger('config_id');
      $table->string('display_name', 60);
      $table->unsignedInteger('value')->comment('值');
      $table->string('color', 20)->nullable();
      $table->unsignedSmallInteger('sort')->nullable();
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
    Schema::dropIfExists('config_options');
  }
}
