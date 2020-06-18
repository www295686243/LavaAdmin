<?php

namespace App\Observers;

use App\Models\Version;

class VersionObserver
{
  public function updated()
  {
    (new Version())->clearCache();
  }
}
