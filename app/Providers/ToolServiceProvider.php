<?php

namespace App\Providers;

use App\Tools\Resource;
use Illuminate\Support\ServiceProvider;

class ToolServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->singleton('res', function () {
      return new Resource();
    });
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
