<?php

namespace App\Providers;

use App\Models\Config;
use App\Models\ConfigOption;
use App\Models\Version;
use App\Observers\ConfigObserver;
use App\Observers\ConfigOptionObserver;
use App\Observers\VersionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    if ($this->app->environment() !== 'production') {
      $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
    }
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Config::observe(ConfigObserver::class);
    ConfigOption::observe(ConfigOptionObserver::class);
    Version::observe(VersionObserver::class);
  }
}
