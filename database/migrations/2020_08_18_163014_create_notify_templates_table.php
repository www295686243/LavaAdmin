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
      $table->string('host', 60)->comment('域名,格式：https://m.yuancaowang.com');
      $table->string('url', 120)->comment('跳转地址，格式：/xxx');
      // 格式 xxx,xxx,xxx
      $table->string('url_params', 120)->comment('地址参数')->nullable();
      // 格式 name,姓名|date,日期|xxx,xxx
      $table->string('keyword_names', 120)->comment('字段名称')->nullable();
      $table->unsignedTinyInteger('queue')->comment('优先级')->default(5);
      $table->unsignedTinyInteger('is_push_official_account')->comment('是否推送微信公众号')->default(0);
      $table->unsignedTinyInteger('is_push_message')->comment('是否推送站内信')->default(0);
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
    Schema::dropIfExists('notify_templates');
  }
}
