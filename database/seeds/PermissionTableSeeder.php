<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $data = [
      (new \Database\Seeders\Permissions\Admin\System())->get(),
      (new \Database\Seeders\Permissions\Admin\Hr())->get(),
      (new \Database\Seeders\Permissions\Admin\Operation())->get(),
      (new \Database\Seeders\Permissions\Admin\User())->get(),
      (new \Database\Seeders\Permissions\Admin\Financial())->get(),
      (new \Database\Seeders\Permissions\Admin\Other())->get(),
      (new \Database\Seeders\Permissions\Client\User())->get(),
    ];
    \App\Models\Permission::rebuildTree($data);
  }
}
