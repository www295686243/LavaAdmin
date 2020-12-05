<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoPushesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('info_pushes', function (Blueprint $table) {
      $table->id();
      $table->string('info_pushable_type', 120);
      $table->unsignedBigInteger('info_pushable_id')->nullable();
      $table->json('industries')->comment('推送的3级行业集合')->nullable();
      $table->json('cities')->comment('推送的3级城市集合')->nullable();
      $table->unsignedBigInteger('user_id')->comment('推送人');
      $table->json('push_users')->comment('推送给了哪些人')->nullable();
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
    Schema::dropIfExists('info_pushes');
  }
}
