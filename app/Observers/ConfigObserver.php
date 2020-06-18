<?php

namespace App\Observers;

use App\Models\Version;

class ConfigObserver
{
  public function updated()
  {
    (new Version())->updateVersion('config');
  }
}
