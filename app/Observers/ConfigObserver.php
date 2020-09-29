<?php

namespace App\Observers;

use App\Models\Config;
use App\Models\Version;

class ConfigObserver
{
  /**
   * @param Config $config
   */
  public function created(Config $config)
  {
    (new Version())->updateOrCreateVersion($config->guard_name, '选项配置');
  }

  public function updated(Config $config)
  {
    (new Version())->updateOrCreateVersion($config->guard_name, '选项配置');
  }

  public function deleted(Config $config)
  {
    (new Version())->updateOrCreateVersion($config->guard_name, '选项配置');
  }
}
