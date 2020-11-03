<?php

namespace App\Observers;

use App\Models\Task\Task;
use App\Models\Version;
use Illuminate\Support\Facades\Cache;

class TaskRuleObserver
{
  /**
   * Handle the task rule "created" event.
   *
   * @return void
   */
  public function created()
  {
    Cache::tags(Task::class)->forget((new Task())->getTable());
    (new Version())->updateOrCreateVersion('task', '任务版本');
  }

  /**
   * Handle the task rule "updated" event.
   *
   * @return void
   */
  public function updated()
  {
    Cache::tags(Task::class)->forget((new Task())->getTable());
    (new Version())->updateOrCreateVersion('task', '任务版本');
  }

  public function deleted()
  {
    (new Version())->updateOrCreateVersion('task', '任务版本');
  }
}
