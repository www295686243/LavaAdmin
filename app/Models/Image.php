<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
    'height',
    'marking'
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

  public function updateImageableId($info_id)
  {
    $marking = request()->input('marking');
    self::where('marking', $marking)->update(['imageable_id' => $info_id]);
    $this->destroySurplus();
  }

  /**
   * @return mixed
   */
  private function destroySurplus()
  {
    $query = self::where('imageable_id', 0)->orWhereNull('imageable_id');
    return $this->delImages($query);
  }

  /**
   * @param Builder $query
   * @return mixed
   */
  public function delImages(Builder $query)
  {
    $list = $query->get();
    foreach ($list as $item) {
      Storage::delete($item->url);
    }
    return $query->delete();
  }
}
