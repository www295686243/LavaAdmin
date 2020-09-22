<?php

namespace App\Models\User;

use App\Models\Base;
use App\Models\Image;
use Kra8\Snowflake\HasSnowflakePrimary;

class UserPersonalAuth extends Base
{
  use HasSnowflakePrimary;
  protected $fillable = [
    'user_id',
    'name',
    'company',
    'position',
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