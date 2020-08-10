<?php

namespace App\Models\User;

use App\Models\Base;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEnterprise extends Base
{
  use SoftDeletes;

  protected $fillable = [
    'user_id',
    'company',
    'business_license',
    'city',
    'address',
    'intro',
    'tags',
    'company_images',
    'company_scale',
    'name',
    'id_card',
    'position'
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
