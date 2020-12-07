<?php

namespace App\Models\Info;

use App\Models\Base;
use App\Models\Info\Hr\HrJob;
use App\Models\Info\Hr\HrResume;
use App\Models\Notify\NotifyTemplate;
use App\Models\User\User;

class InfoComplaint extends Base
{
  protected $fillable = [
    'user_id',
    'info_complaintable_type',
    'info_complaintable_id',
    'complaint_type',
    'complaint_content',
    'handle_content',
    'is_solve',
  ];

  protected $casts = [
    'info_complaintable_id' => 'string'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function info_complaintable()
  {
    return $this->morphTo();
  }
}
