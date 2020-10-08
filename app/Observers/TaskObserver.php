<?php

namespace App\Observers;

use App\Models\Task\Task;
use Illuminate\Support\Facades\Cache;

class TaskObserver
{
  /**
   * Handle the task "created" event.
   *
   * @param \App\Models\Task\Task $task
   * @return void
   */
  public function created(Task $task)
  {
    Cache::tags(Task::class)->forget((new Task())->getTable());
  }

  /**
   * Handle the task "updated" event.
   *
   * @param \App\Models\Task\Task $task
   * @return void
   */
  public function updated(Task $task)
  {
    Cache::tags(Task::class)->forget((new Task())->getTable());
  }
}
