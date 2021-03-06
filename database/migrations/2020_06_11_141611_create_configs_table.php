<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('configs', function (Blueprint $table) {
      $table->id('id');
      $table->string('name', 120);
      $table->string('display_name', 60);
      $table->string('value', 120)->nullable();
      $table->string('guard_name')->comment('守卫(system)');
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
    Schema::dropIfExists('configs');
  }
}
