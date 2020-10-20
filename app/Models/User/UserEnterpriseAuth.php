<?php

namespace App\Models\User;

use App\Models\Base;
use App\Models\Image;

class UserEnterpriseAuth extends Base
{
  protected $fillable = [
    'user_id',
    'company',
    'business_license',
    'city',
    'address',
    'intro',
    'certificates',
    'auth_status',
    'refuse_reason'
  ];

  /**
   * @var array
   */
  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  protected $casts = [
    'certificates' => 'array'
  ];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function images()
  {
    return $this->morphMany(Image::class, 'imageable');
  }
}
