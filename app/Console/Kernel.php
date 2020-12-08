<?php

namespace App\Console;

use App\Models\ApiLog;
use App\Models\Chart\Chart;
use App\Models\Coupon\CouponMarket;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    //
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    $schedule->call(function () {
      ApiLog::storeLog();
      (new CouponMarket())->setExpiredCoupon();
    })->dailyAt('5:00');
    $schedule->call(function () {
      (new Chart())->createData(date('Y-m-d', strtotime('-1 day')));
    })->dailyAt('6:00');
  }

  /**
   * Register the commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
    $this->load(__DIR__ . '/Commands');

    require base_path('routes/console.php');
  }
}
