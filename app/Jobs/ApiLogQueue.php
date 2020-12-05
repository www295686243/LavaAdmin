<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class ApiLogQueue implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $tries = 3;

  public $timeout = 300;

  protected $logs = [];

  /**
   * ApiLogQueue constructor.
   * @param $logs
   */
  public function __construct($logs)
  {
    $this->queue = 'default';
    $this->logs = $logs;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $api_logs = Cache::tags('app')->get('api_logs:'.date('Y-m-d'), []);
    $api_logs = array_merge($api_logs, $this->logs);
    Cache::tags('app')->put('api_logs:'.date('Y-m-d'), $api_logs);
  }
}
