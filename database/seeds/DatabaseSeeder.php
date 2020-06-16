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
      VersionTableSeeder::class,
      UserTableSeeder::class,
      ConfigTableSeeder::class,
      NewsTableSeeder::class,
    ]);
  }
}
