<?php

namespace App\Models\User;

use App\Models\Base\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserControl extends Base
{
  use SoftDeletes;

  protected $fillable = [
    'user_id',
    'is_disable_all_push',
    'is_open_resume_push',
    'is_open_job_push'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  /**
   * @return array
   */
  public static function getUpdateFillable()
  {
    return collect(static::getFillFields())->diff(['user_id'])->values()->toArray();
  }
}
