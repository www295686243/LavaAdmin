<?php

namespace App\Models\User;

use App\Models\Base;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

class UserPersonal extends Base
{
  use SoftDeletes, HasSnowflakePrimary;

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

  protected $casts = [
    'id' => 'string',
    'user_id' => 'string',
    'tags' => 'array',
    'education_experience' => 'array',
    'work_experience' => 'array',
    'honorary_certificate' => 'array'
  ];

  /**
   * @return array
   */
  public static function getUpdateFillable()
  {
    return collect(static::getFillFields())->diff(['user_id'])->values()->toArray();
  }
}
