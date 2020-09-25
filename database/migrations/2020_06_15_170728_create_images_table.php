<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('images', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id')->comment('上传的会员id');
      $table->string('imageable_type', 120);
      $table->unsignedBigInteger('imageable_id');
      $table->string('name')->comment('文件名称');
      $table->string('url', 120)->comment('文件路径');
      $table->string('mime', 20)->comment('Mime类型');
      $table->unsignedInteger('size')->comment('文件大小');
      $table->float('width', 8, 2)->comment('图片宽度')->default(0.00);
      $table->float('height', 8, 2)->comment('图片高度')->default(0.00);
      $table->unsignedBigInteger('marking')->comment('标记(信息发布时用到)')->nullable();
      $table->timestamps();

      $table->index('imageable_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('images');
  }
}
