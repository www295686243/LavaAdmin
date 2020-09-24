<?php

namespace App\Models\Info\Hr;

use App\Models\Base;
use App\Models\Info\InfoSub;
use App\Models\User\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

class HrResume extends Base
{
  use HasSnowflakePrimary, SoftDeletes;

  protected $fillable = [
    'user_id',
    'title',
    'intro',
    'monthly_pay_min',
    'monthly_pay_max',
    'is_negotiate',
    'education',
    'seniority',
    'treatment',
    'treatment_input',
    'city',
    'end_time',
    'contacts',
    'phone',
    'is_force_show_user_info',
    'status',
    'is_other_user',
    'refresh_at',
    'admin_user_id'
  ];

  protected $casts = [
    'admin_user_id' => 'string',
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
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function info_sub()
  {
    return $this->morphMany(InfoSub::class, 'info_subable');
  }

}
