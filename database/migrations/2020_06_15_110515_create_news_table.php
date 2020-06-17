<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('news', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('text')->nullable();
      $table->string('textarea')->nullable();
      $table->unsignedInteger('select')->nullable();
      $table->unsignedInteger('radio')->nullable();
      $table->unsignedTinyInteger('switch')->nullable();
      $table->timestamp('datetime')->nullable();
      $table->json('checkbox')->nullable();
      $table->unsignedSmallInteger('counter')->nullable();
      $table->string('file')->nullable();
      $table->string('image')->nullable();
      $table->json('files')->nullable();
      $table->json('images')->nullable();
      $table->unsignedSmallInteger('cascader')->nullable();
      $table->string('editor')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('news');
  }
}
