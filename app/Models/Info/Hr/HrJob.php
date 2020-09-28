<?php

namespace App\Models\Info\Hr;

use App\Models\Base;
use App\Models\Info\Industry;
use App\Models\Info\InfoSub;
use App\Models\Traits\IndustryTrait;
use App\Models\User\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

class HrJob extends Base
{
  use HasSnowflakePrimary, SoftDeletes, IndustryTrait;

  protected $fillable = [
    'user_id',
    'title',
    'intro',
    'company_name',
    'monthly_pay_min',
    'monthly_pay_max',
    'is_negotiate',
    'recruiter_number',
    'education',
    'seniority',
    'treatment',
    'treatment_input',
    'city',
    'address',
    'end_time',
    'contacts',
    'phone',
    'status',
    'is_other_user',
    'refresh_at',
    'admin_user_id',
    'provide_user_id',
  ];

  protected $casts = [
    'admin_user_id' => 'string',
    'provide_user_id' => 'string',
  ];

  /**
   * @var array
   */
  protected $hidden = [
    'updated_at',
    'deleted_at'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function admin_user()
  {
    return $this->belongsTo(User::class, 'admin_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function provide_user()
  {
    return $this->belongsTo(User::class, 'provide_user_id');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function info_sub()
  {
    return $this->morphMany(InfoSub::class, 'info_subable');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function industry()
  {
    return $this->morphToMany(Industry::class, 'industrygable');
  }
}
