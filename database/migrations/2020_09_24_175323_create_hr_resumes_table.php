<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrResumesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('hr_resumes', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('title', 120)->comment('简历标题');
      $table->string('intro', 120)->comment('简介')->nullable();
      $table->unsignedMediumInteger('monthly_salary_min')->comment('最小月薪')->nullable();
      $table->unsignedMediumInteger('monthly_salary_max')->comment('最大月薪')->nullable();
      $table->unsignedTinyInteger('is_negotiate')->comment('是否面议')->default(0);
      $table->unsignedMediumInteger('education')->comment('学历')->nullable();
      $table->unsignedMediumInteger('seniority')->comment('工作年限')->nullable();
      //xxx,xxx,xxx
      $table->string('treatment', 255)->comment('待遇')->nullable();
      $table->string('treatment_input', 255)->comment('待遇手输')->nullable();
      $table->unsignedInteger('city')->comment('期望城市(省市区)')->nullable();
      $table->date('end_time')->comment('截止日期')->nullable();
      $table->string('contacts', 20)->comment('联系人')->nullable();
      $table->string('phone', 15)->comment('联系电话')->nullable();
      $table->unsignedMediumInteger('status')->comment('0审核1发布2解决3下架');
      $table->unsignedInteger('views')->comment('查看数')->default(0);
      $table->unsignedSmallInteger('pay_count')->comment('支付数')->default(0);
      $table->timestamp('refresh_at')->comment('刷新时间')->nullable();
      $table->unsignedBigInteger('admin_user_id')->comment('信息归属人，用于员工后台发布能知道谁发的')->nullable();
      $table->unsignedBigInteger('provide_user_id')->comment('信息提供人')->nullable();

      $table->timestamps();
      $table->softDeletes();

      $table->index('user_id');
      $table->index('city');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('hr_resumes');
  }
}
