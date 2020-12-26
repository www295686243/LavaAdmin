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
      RoleHasPermissionsSeeder::class,
//      UserTableSeeder::class,
//      HrJobTableSeeder::class,
//      HrResumeTableSeeder::class,
      \Database\Seeders\Data\UserTableSeeder::class,
      \Database\Seeders\Data\CouponTableSeeder::class,
      \Database\Seeders\Data\JobTableSeeder::class,
      \Database\Seeders\Data\ResumeTableSeeder::class,
      \Database\Seeders\Data\ShareLogTableSeeder::class,
      \Database\Seeders\Data\InfoProvideTableSeeder::class,
      \Database\Seeders\Data\TaskTableSeeder::class,
      \Database\Seeders\Data\InfoViewTableSeeder::class,
      \Database\Seeders\Data\OrderTableSeeder::class,
      \Database\Seeders\Data\IndustryTableSeeder::class,
    ]);
  }
}
