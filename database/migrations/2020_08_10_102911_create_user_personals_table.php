<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPersonalsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_personals', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('name', 20)->comment('姓名')->nullable();
      $table->string('id_card', 18)->comment('身份证号(实名后不可修改)')->nullable();
      $table->unsignedTinyInteger('seniority')->comment('工作年限')->nullable();
      $table->string('intro', 255)->comment('个人简介')->nullable();
      $table->string('company', 60)->comment('公司名')->nullable();
      $table->string('position', 60)->comment('职位')->nullable();
      $table->unsignedMediumInteger('city')->comment('省市区')->nullable();
      $table->string('address', 60)->comment('详细地址')->nullable();
      // ['能力强'，'有经验']
      $table->json('tags')->comment('自我评价标签')->nullable();
      // [{minDate: '2011-01', maxDate: '2012-01', school: '学校名', profession: '专业名'}]
      $table->json('education_experience')->comment('教育经历')->nullable();
      // [{minDate: '2011-01', maxDate: '2012-01', company: '公司名', position: '职位名', city: '城市', address: '街道地址'}]
      $table->json('work_experience')->comment('工作经历')->nullable();
      // [{name: '证书名称', images: ['img_url', 'img_url']}]
      $table->json('honorary_certificate')->comment('荣誉证书')->nullable();

      $table->timestamps();
      $table->softDeletes();

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
    Schema::dropIfExists('user_personals');
  }
}
