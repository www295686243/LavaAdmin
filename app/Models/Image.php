<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Kra8\Snowflake\HasSnowflakePrimary;

class Image extends Base
{
  use HasSnowflakePrimary;

  protected $fillable = [
    'user_id',
    'imageable_type',
    'imageable_id',
    'name',
    'url',
    'mime',
    'size',
    'width',
    'height'
  ];

  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /**
   * @var array
   */
  protected $appends = [
    'full_url'
  ];

  /**
   * @return string
   */
  public function getFullUrlAttribute()
  {
    return Storage::url($this->url);
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function imageable()
  {
    return $this->morphTo();
  }
}
