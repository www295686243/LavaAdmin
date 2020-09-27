<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEnterprisesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_enterprises', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id');
      $table->string('avatar', 255)->comment('企业LOGO')->nullable();
      $table->string('company', 60)->comment('公司名(企业认证后不可修改)')->nullable();
      $table->string('business_license', 18)->comment('营业执照(企业认证后不可修改)')->nullable();
      $table->unsignedInteger('city')->comment('省市区')->nullable();
      $table->string('address', 60)->comment('详细地址')->nullable();
      $table->string('intro', 255)->comment('公司简介')->nullable();
      $table->unsignedMediumInteger('industry_attr')->comment('行业属性')->nullable();
      // xxx,xxx
      $table->string('tags')->comment('公司标签')->nullable();
      // ['', '']
      $table->json('company_images')->comment('公司图片')->nullable();
      $table->unsignedMediumInteger('company_scale')->comment('企业规模')->nullable();

      $table->string('name', 20)->comment('运营人姓名')->nullable();
      $table->string('id_card', 18)->comment('运营人身份证')->nullable();
      $table->string('position', 60)->comment('运营人职位')->nullable();
      $table->string('phone', 20)->comment('运营人电话')->nullable();
      $table->string('email')->comment('运营人邮箱')->nullable();

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
    Schema::dropIfExists('user_enterprises');
  }
}
