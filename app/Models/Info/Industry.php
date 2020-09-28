<?php

namespace App\Models\Info;

use App\Models\Base;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\User\UserEnterprise;
use App\Models\User\UserPersonal;
use Kalnoy\Nestedset\NodeTrait;

class Industry extends Base
{
  use NodeTrait;

  protected $fillable = [
    'parent_id',
    'display_name',
    'sort',
    'hr_job_amount',
    'hr_resume_amount',
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'hr_job_amount' => 'float',
    'hr_resume_amount' => 'float',
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function user_personal()
  {
    return $this->morphedByMany(UserPersonal::class, 'industrygable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function user_enterprise()
  {
    return $this->morphedByMany(UserEnterprise::class, 'industrygable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function hr_job()
  {
    return $this->morphedByMany(HrJob::class, 'industrygable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function hr_resume()
  {
    return $this->morphedByMany(HrResume::class, 'industrygable');
  }
}
