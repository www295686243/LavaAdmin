<?php

namespace App\Observers;

use App\Models\Task\Task;
use App\Models\Version;
use Illuminate\Support\Facades\Cache;

class TaskObserver
{
  /**
   * Handle the task "created" event.
   *
   * @param \App\Models\Task\Task $task
   * @return void
   */
  public function created()
  {
    Cache::tags(Task::class)->forget((new Task())->getTable());
    (new Version())->updateOrCreateVersion('task', '任务版本');
  }

  /**
   * Handle the task "updated" event.
   *
   * @param \App\Models\Task\Task $task
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
