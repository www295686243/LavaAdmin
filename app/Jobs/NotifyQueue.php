<?php

namespace App\Jobs;

use App\Models\Notify\Notify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyQueue implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $tries = 3;

  public $timeout = 300;

  protected $notify = null;

  /**
   * NotifyQueue constructor.
   * @param $notify
   */
  public function __construct(Notify $notify)
  {
    $this->notify = $notify;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $this->notify->pushWeChatNotify();
  }
}
