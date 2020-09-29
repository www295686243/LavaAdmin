<?php

namespace App\Observers;

use App\Models\Info\Industry;
use App\Models\Version;

class IndustryObserver
{
  /**
   * Handle the industry "created" event.
   *
   * @param  \App\Models\Info\Industry $industry
   * @return void
   */
  public function created(Industry $industry)
  {
    (new Version())->updateOrCreateVersion('industry', '行业版本');
  }

  /**
   * Handle the industry "updated" event.
   *
   * @param  \App\Models\Info\Industry $industry
   * @return void
   */
  public function updated(Industry $industry)
  {
    (new Version())->updateOrCreateVersion('industry', '行业版本');
  }

  /**
   * Handle the industry "deleted" event.
   *
   * @param  \App\Models\Info\Industry $industry
   * @return void
   */
  public function deleted(Industry $industry)
  {
    (new Version())->updateOrCreateVersion('industry', '行业版本');
  }
}
