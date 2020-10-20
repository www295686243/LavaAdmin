<?php

namespace App\Models\User;

use App\Models\Base;
use App\Models\Info\Industry;
use App\Models\Traits\IndustryTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEnterprise extends Base
{
  use SoftDeletes, IndustryTrait;

  protected $fillable = [
    'user_id',
    'avatar',
    'company',
    'business_license',
    'city',
    'address',
    'intro',
    'industry_attr',
    'email',
    'tags',
    'company_images',
    'company_scale',
    'name',
    'id_card',
    'position',
    'phone'
  ];

  protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at'
  ];

  protected $casts = [
    'company_images' => 'array'
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
