<?php

namespace App\Observers;

use App\Models\Task\TaskRule;
use Illuminate\Support\Facades\Cache;

class TaskRuleObserver
{
  /**
   * Handle the task rule "created" event.
   *
   * @param \App\Models\Task\TaskRule $taskRule
   * @return void
   */
  public function created(TaskRule $taskRule)
  {
    Cache::tags(TaskRule::class)->forget((new TaskRule())->getTable());
  }

  /**
   * Handle the task rule "updated" event.
   *
   * @param \App\Models\Task\TaskRule $taskRule
   * @return void
   */
  public function updated(TaskRule $taskRule)
  {
    Cache::tags(TaskRule::class)->forget((new TaskRule())->getTable());
  }
}
