<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndustrygablesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('industrygables', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('industry_id');
      $table->unsignedBigInteger('industrygable_id');
      $table->string('industrygable_type', 120);
      $table->unsignedBigInteger('industry_root_id')->nullable();
      $table->string('industry_path', 120)->nullable();
      $table->timestamps();
      $table->softDeletes();

      $table->index('industry_id');
      $table->index('industry_root_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('industrygables');
  }
}
