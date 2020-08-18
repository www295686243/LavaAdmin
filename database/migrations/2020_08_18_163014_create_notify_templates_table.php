<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifyTemplatesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('notify_templates', function (Blueprint $table) {
      $table->id();
      $table->string('template_id', 80)->comment('微信模板id');
      $table->string('title', 60)->comment('通知标题');
      $table->string('content', 120)->comment('通知内容');
      $table->string('remark', 120)->comment('通知备注');
      $table->string('url', 120)->comment('跳转地址');
      $table->json('keyword_names')->comment('字段名称');
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
    Schema::dropIfExists('notify_templates');
  }
}
