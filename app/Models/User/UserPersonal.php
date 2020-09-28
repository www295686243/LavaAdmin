<?php

namespace App\Models\User;

use App\Models\Base;
use App\Models\Info\Industry;
use App\Models\Traits\IndustryTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

class UserPersonal extends Base
{
  use SoftDeletes, HasSnowflakePrimary, IndustryTrait;

  protected $fillable = [
    'user_id',
    'avatar',
    'name',
    'id_card',
    'seniority',
    'intro',
    'email',
    'phone',
    'company',
    'position',
    'position_attr',
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

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
   */
  public function industry()
  {
    return $this->morphToMany(Industry::class, 'industrygable');
  }
}
