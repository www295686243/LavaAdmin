<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminMenusTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('admin_menus', function (Blueprint $table) {
      $table->id();
      $table->string('display_name', 30)->comment('菜单名称');
      $table->string('desc', 120)->comment('菜单描述')->nullable();
      $table->string('route', 120)->comment('路由')->nullable();
      $table->string('icon', 30)->comment('icon图标')->nullable();
      $table->json('params')->comment('所需参数(一般二级以上的菜单会用到)')->nullable();
      $table->json('default_params')->comment('默认参数')->nullable();
      $table->unsignedSmallInteger('sort')->comment('排序')->nullable();
      $table->unsignedInteger('_lft')->default(0);
      $table->unsignedInteger('_rgt')->default(0);
      $table->unsignedBigInteger('parent_id')->nullable();

      $table->timestamps();

      $table->index(['_lft', '_rgt', 'parent_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('admin_menus');
  }
}
