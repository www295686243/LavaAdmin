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
      ConfigTableSeeder::class,
      CityTableSeeder::class,
      CouponTemplateSeeder::class,
      NotifyTemplateTableSeeder::class,
      VersionTableSeeder::class,
      AdminMenuTableSeeder::class,
      TaskTableSeeder::class,
      PermissionTableSeeder::class,
      RoleTableSeeder::class,
      UserTableSeeder::class,
//      NewsTableSeeder::class,
      HrJobTableSeeder::class,
      HrResumeTableSeeder::class,
    ]);
  }
}
