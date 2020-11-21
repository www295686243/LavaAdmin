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
      CityTableSeeder::class,
      AdminMenuTableSeeder::class,
      PermissionTableSeeder::class,
      RoleTableSeeder::class,
      UserTableSeeder::class,
//      NewsTableSeeder::class,
      VersionTableSeeder::class,
      ConfigTableSeeder::class,
      NotifyTemplateTableSeeder::class,
      HrJobTableSeeder::class,
      HrResumeTableSeeder::class,
      CouponTemplateSeeder::class,
      TaskTableSeeder::class,
    ]);
  }
}
