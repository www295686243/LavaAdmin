<?php

namespace App\Observers;

use App\Models\ConfigOption;
use App\Models\Version;

class ConfigOptionObserver
{
  /**
   * Handle the config option "created" event.
   *
   * @param  \App\Models\ConfigOption $configOption
   * @return void
   */
  public function created(ConfigOption $configOption)
  {
    (new Version())->updateOrCreateVersion($configOption->config->guard_name, $configOption->config->display_name);
  }

  /**
   * Handle the config option "updated" event.
   *
   * @param  \App\Models\ConfigOption $configOption
   * @return void
   */
  public function updated(ConfigOption $configOption)
  {
    (new Version())->updateOrCreateVersion($configOption->config->guard_name, $configOption->config->display_name);
  }

  /**
   * Handle the config option "deleted" event.
   *
   * @param  \App\Models\ConfigOption $configOption
   * @return void
   */
  public function deleted(ConfigOption $configOption)
  {
    (new Version())->updateOrCreateVersion($configOption->config->guard_name, $configOption->config->display_name);
  }
}
