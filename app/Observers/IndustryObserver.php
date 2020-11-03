<?php

namespace App\Observers;

use App\Models\Info\Industry;
use App\Models\Version;
use Illuminate\Support\Facades\Cache;

class IndustryObserver
{
  /**
   * Handle the industry "created" event.
   *
   * @return void
   */
  public function created()
  {
    (new Version())->updateOrCreateVersion('industry', '行业版本');
    Cache::tags(Industry::class)->forget((new Industry())->getTable());
  }

  /**
   * Handle the industry "updated" event.
   *
   * @return void
   */
  public function updated()
  {
    (new Version())->updateOrCreateVersion('industry', '行业版本');
    Cache::tags(Industry::class)->forget((new Industry())->getTable());
  }

  /**
   * Handle the industry "deleted" event.
   *
   * @return void
   */
  public function deleted()
  {
    (new Version())->updateOrCreateVersion('industry', '行业版本');
    Cache::tags(Industry::class)->forget((new Industry())->getTable());
  }
}
