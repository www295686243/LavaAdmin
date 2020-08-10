<?php

namespace App\Models\User;

use App\Models\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPersonal extends Base
{
  use SoftDeletes;

  protected $fillable = [
    'user_id',
    'name',
    'id_card',
    'seniority',
    'intro',
    'company',
    'position',
    'city',
    'address',
    'tags',
    'education_experience',
    'work_experience',
    'honorary_certificate'
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
