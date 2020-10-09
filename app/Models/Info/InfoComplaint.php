<?php

namespace App\Models\Info;

use App\Models\Base;
use App\Models\User\User;
use Kra8\Snowflake\HasSnowflakePrimary;

class InfoComplaint extends Base
{
  use HasSnowflakePrimary;

  protected $fillable = [
    'user_id',
    'info_complaintable_type',
    'info_complaintable_id',
    'complaint_type',
    'complaint_content',
    'handle_content',
    'is_solve',
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
