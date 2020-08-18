<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('notifies', function (Blueprint $table) {
      $table->id();
      $table->string('title', 60)->comment('发送类型标题');
      $table->unsignedBigInteger('user_id')->comment('发送人');
      $table->string('openid', 60)->comment('微信用户唯一id')->nullable();
      $table->string('template_id', 100)->comment('模板id');
      $table->string('url', 255)->comment('url');
      $table->json('url_params')->comment('url参数')->nullable();
      $table->string('content', 100)->comment('信息内容');
      $table->string('remark', 100)->comment('备注');
      $table->json('keywords')->comment('参数')->nullable();
      $table->json('keyword_names')->comment('参数名')->nullable();
      $table->unsignedTinyInteger('is_read')->comment('是否已阅读')->default(0);
      $table->string('type_name', 30)->comment('发送类型all/wechat/message');
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
    Schema::dropIfExists('notifies');
  }
}
