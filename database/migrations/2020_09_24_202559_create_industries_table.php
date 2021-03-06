<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndustriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    if (!Schema::hasTable('industries')) {
      Schema::create('industries', function (Blueprint $table) {
        $table->id();
        $table->string('display_name', 30)->comment('名称');
        $table->unsignedInteger('sort')->comment('排序')->nullable();
        $table->decimal('hr_job_amount', 8, 2)->comment('招聘金额')->nullable();
        $table->decimal('hr_resume_amount', 8, 2)->comment('求职金额')->nullable();
        $table->unsignedInteger('_lft')->default(0);
        $table->unsignedInteger('_rgt')->default(0);
        $table->unsignedBigInteger('parent_id')->nullable();
        $table->timestamps();

        $table->index(['_lft', '_rgt', 'parent_id']);
      });
    }
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
//    Schema::dropIfExists('industries');
  }
}
