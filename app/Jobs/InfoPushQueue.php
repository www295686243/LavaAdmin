<?php

namespace App\Jobs;

use App\Models\City;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\UserControl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class InfoPushQueue implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public $tries = 3;

  public $timeout = 300;

  protected $user_id;
  protected $infoData;

  /**
   * InfoPushQueue constructor.
   * @param $user_id
   * @param $infoData
   */
  public function __construct($user_id, $infoData)
  {
    $this->queue = 'low';
    $this->user_id = $user_id;
    $this->infoData = $infoData;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $userControlData = UserControl::where('user_id', $this->user_id)->first();
    if ($userControlData && !$userControlData->is_disable_all_push) {
      $className = get_class($this->infoData);
      if (Str::contains($className, 'HrJob') && $userControlData->is_open_job_push) {
        NotifyTemplate::send(21, '招聘信息推送', $this->user_id, [
          'id' => $this->infoData->id,
          'company' => $this->infoData->company_name,
          'title' => $this->infoData->title,
          'industry' => $this->infoData->industry->pluck('display_name'),
          'city' => (new City())->getNames($this->infoData->city),
          'monthly' => $this->infoData->is_negotiate ? '面议' : $this->infoData->monthly_salary_min.'~'.$this->infoData->monthly_salary_max
        ]);
      } else if (Str::contains($className, 'HrResume') && $userControlData->is_open_resume_push) {
        NotifyTemplate::send(23, '简历信息推送', $this->user_id, [
          'id' => $this->infoData->id,
          'title' => $this->infoData->title,
          'city' => (new City())->getNames($this->infoData->city),
          'contacts' => $this->infoData->contacts,
          'created_at' => $this->infoData->created_at->format('Y-m-d H:i:s')
        ]);
      }
    }
  }
}
