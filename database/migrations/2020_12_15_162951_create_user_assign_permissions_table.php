<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAssignPermissionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('user_assign_permissions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('role_id');
      $table->unsignedBigInteger('permission_id');
      $table->string('platform');
      $table->timestamps();

      $table->index('role_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('user_assign_permissions');
  }
}
