<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoViewsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('info_views', function (Blueprint $table) {
      $table->id();
      $table->string('info_viewable_type', 120);
      $table->unsignedBigInteger('info_viewable_id');
      $table->unsignedBigInteger('share_user_id')->comment('分享者')->nullable();
      $table->unsignedBigInteger('user_id')->comment('访问者');
      $table->unsignedTinyInteger('is_new_user')->comment('是否新用户')->default(0);
      $table->timestamps();

      $table->index('info_viewable_id');
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
    Schema::dropIfExists('info_views');
  }
}
