<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call([
      AdminMenuTableSeeder::class,
      PermissionTableSeeder::class,
      RoleTableSeeder::class,
      UserTableSeeder::class,
      NewsTableSeeder::class,
      VersionTableSeeder::class,
      NotifyTemplateTableSeeder::class,
    ]);
  }
}
